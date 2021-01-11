<?php

namespace jtx\foreup\Interfaces;

interface GolfAPIInterface
{
    /**
     * @return string
     */
    public function auth(): string;

    /**
     * @param string $jwt
     * @param int $courseId
     * @param array $customer
     * @return bool
     */
    public function createUser(string $jwt, int $courseId, array $customer): bool;
}
