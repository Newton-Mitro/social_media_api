<?php

namespace App\Modules\Content\Reaction\Application\DTOs;

use App\Modules\Auth\Application\DTOs\UserDTO;

class ReactionDTO
{
    public string $id;
    public string $reactable_id;
    public string $reactable_type;
    public UserDTO $user;
    public string $type;
    public string $created_at;
    public string $updated_at;
}
