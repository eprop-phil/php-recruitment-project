<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

interface Piece
{
    public function getColour();

    public function setColour(ColourEnum $pieceColour);

    public function move(int $targetRank, int $targetColumn);

    public function isMoveLegal(int $targetRank, int $targetColumn): bool;

}