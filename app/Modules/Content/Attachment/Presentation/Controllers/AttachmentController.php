<?php

namespace App\Modules\Content\Attachment\Presentation\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Content\Attachment\Application\Mappers\AttachmentMapper;
use App\Modules\Content\Attachment\Application\UseCases\CreateAttachmentUseCase;
use App\Modules\Content\Attachment\Application\UseCases\DeleteAttachmentUseCase;
use App\Modules\Content\Attachment\Application\UseCases\GetAttachmentUseCase;
use App\Modules\Content\Attachment\Application\UseCases\UpdateAttachmentUseCase;
use App\Modules\Content\Attachment\Presentation\Requests\StoreAttachmentRequest;
use App\Modules\Content\Attachment\Presentation\Requests\UpdateAttachmentRequest;
use Illuminate\Http\Response;

class AttachmentController extends Controller
{
    private CreateAttachmentUseCase $createUseCase;
    private UpdateAttachmentUseCase $updateUseCase;
    private DeleteAttachmentUseCase $deleteUseCase;
    private GetAttachmentUseCase $getUseCase;

    public function __construct(
        CreateAttachmentUseCase $createUseCase,
        UpdateAttachmentUseCase $updateUseCase,
        DeleteAttachmentUseCase $deleteUseCase,
        GetAttachmentUseCase $getUseCase
    ) {
        $this->createUseCase = $createUseCase;
        $this->updateUseCase = $updateUseCase;
        $this->deleteUseCase = $deleteUseCase;
        $this->getUseCase = $getUseCase;
    }

    public function index()
    {
        return response()->json([
            'data' => $this->getUseCase->getAll(),
            'message' => 'Fetch attachments successfully.',
            'error' => null,
            'errors' => null,
        ]);
    }

    public function show(string $id)
    {
        $attachment = $this->getUseCase->findById($id);
        return $attachment ?  response()->json([
            'data' => $attachment,
            'message' => 'Fetch attachments successfully.',
            'error' => null,
            'errors' => null,
        ]) : response()->json([
            'data' => null,
            'message' => 'Not Found',
            'error' => null,
            'errors' => null,
        ], Response::HTTP_NOT_FOUND);
    }

    public function store(StoreAttachmentRequest $request)
    {
        $data = $request->validated();
        $attachment = $this->createUseCase->execute($data);
        return response()->json($attachment, 201);
    }

    public function update(UpdateAttachmentRequest $request, string $id)
    {
        $data = $request->validated();
        $updated = $this->updateUseCase->execute($id, $data);
        return $updated ? response()->json(['message' => 'Updated']) : response()->json(['message' => 'Not Found'], 404);
    }

    public function destroy(string $id)
    {
        $deleted = $this->deleteUseCase->execute($id);
        return $deleted ? response()->json(['message' => 'Deleted']) : response()->json(['message' => 'Not Found'], 404);
    }
}
