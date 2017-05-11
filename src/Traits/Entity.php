<?php

namespace Telegram\Bot\Traits;

use Illuminate\Support\Collection;

/**
 * Entity
 */
trait Entity
{

    /**
     * Return all the details about a specific entity from an update.
     *
     * @param int $entityNumber
     *
     * @return Collection
     */
    protected function getEntityDetails(int $entityNumber)
    {
        return $this->getUpdate()->getMessage()->entities->get($entityNumber);
    }

    /**
     * Given the offset and length details of a specific entity from a telegram Update,
     * return all strings in the message after that entity.
     *
     * These can then be used as arguments for commands etc.
     *
     * @param Collection $entityDetails
     *
     * @return Collection
     */
    protected function stringsAfterEntity(Collection $entityDetails): Collection
    {
        return collect(
            explode(' ', $this->stringAfterEntityLocation($entityDetails))
        )->reject(function ($word) {
            return trim($word) == '';
        });
    }

    /**
     * Return the entire string after the given entity from a message.
     *
     * @param Collection $entityDetails
     *
     * @return bool|string
     */
    private function stringAfterEntityLocation(Collection $entityDetails)
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $entityDetails->get('offset') + $entityDetails->get('length')
        );
    }

}