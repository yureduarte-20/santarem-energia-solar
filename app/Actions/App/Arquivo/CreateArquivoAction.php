<?php

use App\Interfaces\Arquivable;
use Illuminate\Support\Facades\Storage;

class CreateArquivoAction
{
    protected function sha256_from(string $path): string
    {
        return hash_file('sha256', $path);
    }
    public function getRules()
    {
        return [
            'arquivo' => 'required|file|mime:doc,docx,pdf',
        ];
    }
    public function from_request(Arquivable $arquiring, Request $request, string $folder = 'documentos')
    {
        ['arquivo' => $file] = $request->validate($this->getRules());
        $filepath = Str::random() . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $filepath);
        $input = [
            'nome' => $file->getClientOriginalName(),
            'path' => $path,
            'sha_256' => $this->sha256_from(Storage::path($path)),
            'size' => Storage::size($path),
            'mimetype' => $file->getMimeType()
        ];
        return $arquiring->createNewArchive($input);
    }
}