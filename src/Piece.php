<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

 // @todo Refactor to an abstract type as this behavior
 //     only applies to chess pieces
 //     and forces base funtionality into being duplicated
 //     in each implemented chess piece
interface Piece
{
    public function getColour():ColourEnum; //@done added type hint

    public function setColour(ColourEnum $pieceColour);

    public function move(int $targetRank, int $targetColumn);

    public function isMoveLegal(int $targetRank, int $targetColumn): bool;

}