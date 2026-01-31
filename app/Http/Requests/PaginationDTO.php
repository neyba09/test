<?php

namespace App\Http\Requests;

class PaginationDTO
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 10
    ) {}
}
