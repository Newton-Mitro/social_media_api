<?php

namespace App\Modules\Content\Reaction\Application\DTOs;

class ReactionDTO
{
    public string $id;
    public string $reactable_id;
    public string $reactable_type;
    public string $user_id;
    public string $type;
    public string $created_at;
    public string $updated_at;
}
