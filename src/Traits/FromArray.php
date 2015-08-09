<?php

    namespace Mbright\Traits;

    trait FromArray
    {
        public function fromArray(array $input)
        {
            foreach ($input as $field => $value) {
                $this->$field = $value;
            }
            return $this;
        }
    }