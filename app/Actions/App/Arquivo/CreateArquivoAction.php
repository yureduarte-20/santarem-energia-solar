<?php
namespace App\Actions\App\Arquivo;
use App\Interfaces\Arquivable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CreateArquivoAction
{
    protected function sha256_from(string $path): string
    {
        return hash_file('sha256', $path);
    }
    public function from_uploaded_file(Arquivable $arquiring, UploadedFile $file, string $folder = 'documentos')
    {
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
