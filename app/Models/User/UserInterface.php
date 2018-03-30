<?php
namespace App\Models\User;

/**
 * Ensure that class will implement all these methods
 */
interface UserInterface
{
    /**
     * Get the user firstname, lastname concatenaded
     */
    public function getFullName();

    /**
     * Get the user email
     */
    public function getEmail();
}
