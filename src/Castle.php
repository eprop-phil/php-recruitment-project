<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

class Castle implements Piece
{
    /**
     * Which rank the castle is on
     * @var integer
     */
    private $rank;

    /**
     * Which column the castle is on
     * @var integer
     */
    private $column;

    /**
     * @var ColourEnum
     */
    private $colour;

    /**
     * The turn number the rook last moved
     * @var integer
     */
    private $lastMove = 0;
    
    /**
     * @var MoveTypeEnum
     */
    private $moveType = MoveTypeEnum::NORMAL;

    /**
     * @param int $targetRank
     * @param int $targetColumn
     * @throws InvalidMoveException
     */
    public function move(int $targetRank, int $targetColumn)
    {
        if ($this->isMoveLegal($targetRank, $targetColumn)) {

            $this->rank   = $targetRank;
            $this->column = $targetColumn;

        } else {

            throw new InvalidMoveException("That move is illegal");

        }

    }

    /**
     * Do not implement this function for the project.  Use the provided stub.
     *
     * @param int $targetRank
     * @param int $targetColumn
     * @return bool
     */
    public function isMoveLegal(int $targetRank, int $targetColumn): bool
    {
        $this->setMoveType(MoveTypeEnum::NORMAL);

        return true;
    }

    /**
     * Implement this function for the project.
     *
     * @return bool
     */
    public function hasMoved() : bool
    {
        return ($this->getLastMove() > 0);
    }

    /**
     * @return int
     */
    public function getLastMove() : int
    {
        return $this->lastMove;
    }

    /**
     * @return void
     */
    public function setLastMove(int $turn)
    {
        $this->lastMove = $turn;
    }

    /**
     * @return ColourEnum
     */
    public function getColour(): ColourEnum
    {
        return $this->colour;
    }

    /**
     * @param ColourEnum $pieceColour
     */
    public function setColour(ColourEnum $pieceColour)
    {
        $this->colour = $pieceColour;
    }


    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @param int $column
     */
    public function setColumn(int $column)
    {
        $this->column = $column;
    }

    /**
     * @//return MoveTypeEnum
     */
    public function getMoveType()
    {
        return $this->moveType;
    }

    /**
     *  @//param MoveTypeEnum $moveType
     */
    public function setMoveType($moveType)
    {
        $this->moveType = $moveType;
    }
}