<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->paginate(10);

        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:128',
            'id_kategori' => 'required|exists:kategori,id',
            'pengarang' => 'required|string|max:64',
            'penerbit' => 'required|string|max:64',
            'tahun_terbit' => 'required|digits:4',
            'isbn' => 'required|string|max:64',
            'stok' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'pengarang.required' => 'Pengarang wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus 4 digit angka.',
            'isbn.required' => 'ISBN wajib diisi.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.numeric' => 'Stok harus berupa angka.',
        ]);

        $imagePath = 'cover-buku/book-default-cover.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cover-buku', 'public');
        }

        Buku::create([
            'judul_buku' => $request->judul_buku,
            'id_kategori' => $request->id_kategori,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'stok' => $request->stok,
            'dipinjam' => 0,
            'dibooking' => 0,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.master.buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori');

        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategori = Kategori::all();

        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:128',
            'id_kategori' => 'required|exists:kategori,id',
            'pengarang' => 'required|string|max:64',
            'penerbit' => 'required|string|max:64',
            'tahun_terbit' => 'required|digits:4',
            'isbn' => 'required|string|max:64',
            'stok' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
        ], [
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        $data = [
            'judul_buku' => $request->judul_buku,
            'id_kategori' => $request->id_kategori,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('image')) {
            if ($buku->image && ! str_contains($buku->image, 'book-default')) {
                Storage::disk('public')->delete($buku->image);
            }
            $data['image'] = $request->file('image')->store('cover-buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.master.buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->dibooking > 0 || $buku->dipinjam > 0) {
            return redirect()->route('admin.master.buku.index')->with('error', 'Buku tidak dapat dihapus karena masih sedang dipinjam atau dibooking.');
        }

        if ($buku->image && ! str_contains($buku->image, 'book-default')) {
            Storage::disk('public')->delete($buku->image);
        }

        $buku->delete();

        return redirect()->route('admin.master.buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}
