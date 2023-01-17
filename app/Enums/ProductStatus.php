<?php

namespace App\Enums;

enum ProductStatus: string
{
    case draft = 'draft';
    case trash = 'trash';
    case published = 'published';
}
