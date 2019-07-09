<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

class King implements Piece
{
    /**
     * Which rank the king is on
     * @var integer
     */
    private $rank;

    /**
     * Which column the king is on
     * @var integer
     */
    private $column;

    /**
     * @var ColourEnum
     */
    private $colour;

    /**
     * The turn number the king last moved
     * @var integer
     */
    private $lastMove = 0;

    /**
     * @var MoveTypeEnum;
     */
    private $moveType = MoveTypeEnum::NORMAL;

    /**
     * @param int $targetRank
     * @param int $targetColumn
     * @throws InvalidMoveException
     */
    public function move(int $targetRank, int $targetColumn): void
    {
        if ($this->isMoveLegal($targetRank, $targetColumn)) {
            $this->rank   = $targetRank;
            $this->column = $targetColumn;

        } else {
            throw new InvalidMoveException("That move is illegal");

        }
    }

    /**
     * Implement this function for the project.
     *
     * A king may move one square in any direction provided that it does not move into a
     * position where it may be captured (See https://en.wikipedia.org/wiki/Check_(chess)).
     *
     * Note that the method isInCheck() is stubbed and you do not need to implement testing if the
     * king is in check for this project.
     *
     * A king may castle subject to certain conditions.  See https://en.wikipedia.org/wiki/Chess#Castling
     *
     * @param int $targetRank
     * @param int $targetColumn
     * @return bool
     */
    public function isMoveLegal(int $targetRank, int $targetColumn): bool
    {
        $this->setMoveType(MoveTypeEnum::NORMAL);

        if ($this->isSuitableCastlePresentForCastling($targetRank, $targetColumn)) {
            $this->setMoveType(MoveTypeEnum::CASTLE);

            return true;
        }

        if (abs($this->rank - $targetRank) > 1) {
            return false;
        }

        if (abs($this->column - $targetColumn) > 1) {
            return false;
        }

        return true;
    }

    /**
     * You do not have to implement this function for the project.
     * Feel free to use this stub.
     *
     * @param int $rank
     * @param int $column
     * @return bool
     */
    public function isInCheck(int $rank, int $column)
    {
        // You do not have to implement this function for the project.  Feel free to use this stub.
        return false;
    }

    /**
     * Implement this function for the project.
     *
     * This function must check that there is a castle that has not moved at the end of the board in the direction
     * of the castling.  It should return true if there is a castle suitable to castle with.
     * See https://en.wikipedia.org/wiki/Chess#Castling
     *
     * @param int $targetRank The rank that the king is moving to
     * @param int $targetColumn The column to which the king is moving to
     * @return bool
     */
    public function isSuitableCastlePresentForCastling(int $targetRank, int $targetColumn): bool
    {
        if ($this->hasMoved()) {
            return false;
        }
        if ($this->isInCheck($targetRank, $targetColumn)) {
            return false;
        }
        if ($targetRank == 1 && $this->getColour() == ColourEnum::BLACK) {
            return false;
        }
        if ($targetRank == 8 && $this->getColour() == ColourEnum::WHITE) {
            return false;
        }

        return in_array($targetColumn , [2, 7]);
        // the king is not currently in check
        // is target rank 1 for white or 8 for black
        // is column 2 or 7
        // if 2 has the rook on square HOME,1 moved
        // if 7 has the rook on square HOME,8 moved
        // are all the squares between king and rook empty
        // are any of the squares between king and rook attacked by any opponent piece

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
     * @return void
     */
    public function setColumn(int $column)
    {
        $this->column = $column;
    }

    /**
     * @//return MoveTypeEnum
     */
    public function getMoveType() //: MoveTypeEnum
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