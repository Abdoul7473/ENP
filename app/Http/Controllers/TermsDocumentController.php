<?php

namespace App\Http\Controllers;

use App\Models\TermsDocument;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TermsDocumentController extends Controller
{
    public function index()
    {
        $docs = TermsDocument::all()->keyBy('type');

        return Inertia::render('terms/index', [
            'docs' => [
                'cgu' => $docs->get('cgu'),
                'deposit' => $docs->get('deposit'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cgu_file' => 'nullable|file|mimes:pdf,doc,docx',
            'deposit_file' => 'nullable|file|mimes:pdf,doc,docx',
        ], [
            'mimes' => 'Le fichier doit être en format PDF ou Word.',
        ]);

        $this->saveDocument('cgu', $request->file('cgu_file'));
        $this->saveDocument('deposit', $request->file('deposit_file'));

        return redirect()->back()->with('success', 'Documents mis à jour avec succès.');
    }

    private function saveDocument(string $type, $file): void
    {
        if (!$file) {
            return;
        }

        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . $type . '.' . $extension;
        $dir = public_path('documents/terms');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file->move($dir, $filename);

        TermsDocument::updateOrCreate(
            ['type' => $type],
            [
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'uploaded_by' => auth()->id(),
            ]
        );
    }
}
