<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

class Chessboard
{
    /**
     * How many squares wide the board is
     */
    const BOARD_LENGTH = 8;

    /**
     * What value in the pieces array will indicate that the square is empty
     */
    const EMPTY_SQUARE = null;

    /**
     * @var array
     */
    private $pieces;

    /**
     * Chessboard constructor.
     */
    public function __construct()
    {
        $this->emptyBoard();
    }

    /**
     * @return void
     */
    private function emptyBoard(): void
    {
        for ($rank=1; $rank <= self::BOARD_LENGTH; $rank++)
        {
            for ($column=1; $column <= self::BOARD_LENGTH; $column++) {
                if (!isset($this->pieces[$rank])) {
                    $this->pieces[$rank] = [];
                }
                $this->pieces[$rank][$column] = self::EMPTY_SQUARE;
            }
        }
    }

    /**
     * @param Piece $piece
     * @param int $rank
     * @param int $column
     * @return void
     */
    public function addPiece(Piece $piece, int $rank, int $column): void
    {
        $this->pieces[$rank][$column] = $piece;
    }

    /**
     * @param int $fromRank
     * @param int $fromColumn
     * @param int $toRank
     * @param int $toColumn
     * @return void
     * @throws \Exception
     */
    public function movePiece(int $fromRank, int $fromColumn, int $toRank, int $toColumn): void
    {
        $movingPiece = $this->getPieceOnSquare($fromRank, $fromColumn);

        $pieceOnTarget = $this->getPieceOnSquare($toRank, $toColumn);

        try {

            if ($pieceOnTarget !== self::EMPTY_SQUARE) {

                if ($movingPiece->getColour() === $pieceOnTarget->getColour()) {

                    throw new InvalidMoveException("You cannot move onto a square occupied by your own piece");

                }

            }

            $this->pieces[$fromRank][$fromColumn] = self::EMPTY_SQUARE;

            $this->pieces[$toRank][$toColumn] = $movingPiece;

            $movingPiece->move($toRank, $toColumn);

        } catch (InvalidMoveException $e) {

            throw new \Exception("Could not move that piece");

        }

    }

    /**
     * @param int $rank
     * @param int $column
     * @return Piece
     */
    public function getPieceOnSquare(int $rank, int $column): ?Piece
    {
        return $this->pieces[$rank][$column];
    }
}