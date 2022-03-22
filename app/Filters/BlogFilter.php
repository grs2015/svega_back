<?php

namespace App\Filters;

class BlogFilter extends QueryFilter {

    public function title($value="asc") {
        return $this->builder->orderBy('title', $value);
    }

    public function date($value="asc") {
        return $this->builder->orderBy('date', $value);
    }

    public function search($keyword) {
        return $this->builder->where('title', 'like', '%'.$keyword.'%')
            ->orWhere('date', 'like', '%'.$keyword.'%');
    }
}
