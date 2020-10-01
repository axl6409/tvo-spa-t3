<?php

namespace Laravel\Socialite\Contracts;

interface User
{
    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getId();

    /**
     * Get the nickname / username for the user.
     *
     * @return string
     */
    public function getNickname();

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the e-mail address of the user.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get the avatar / image URL for the user.
     *
     * @return string
     */
    public function getAvatar();

    /**
     * Get the bungie id for the user.
     *
     * @return string
     */
    public function getBungieId();

    /**
     * Get the membership id for the user.
     *
     * @return string
     */
    public function getMembershipId();

    /**
     * Get the membership type for the user.
     *
     * @return string
     */
    public function getMembershipType();
}
