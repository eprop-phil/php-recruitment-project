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
     * @var array
     */
    CONST HOME_ROW = [ ColourEnum::WHITE => 1, ColourEnum::BLACK => 8];

    /**
     * Track current turn number
     * @var int
     */
    private $turn = 0;

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
        $msg = $this->isValidSquare($rank, $column);
        if ('' != $msg) {
            throw new InvalidMoveException("You must place a piece on the board, {$msg}");

        }
        
        $this->pieces[$rank][$column] = $piece;
        $piece->setRank($rank);
        $piece->setColumn($column);
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
        try {
            $msg = $this->isValidSquare($fromRank, $fromColumn);
            if ('' != $msg) {
                throw new InvalidMoveException("You must place a piece on the board, {$msg}");

            }

            $msg = $this->isValidSquare($toRank, $toColumn);
            if ('' != $msg) {
                throw new InvalidMoveException("You must move a piece to a square on the board, {$msg}");

            }

            if ( ($fromRank == $toRank) && ($fromColumn == $toColumn) ) {
                throw new InvalidMoveException("You cannot move a piece onto the same square it started at");

            }

            $movingPiece = $this->getPieceOnSquare($fromRank, $fromColumn);
            if ( ! $movingPiece->isMoveLegal($toRank, $toColumn)) {
                throw new InvalidMoveException("You cannot move piece to that square");
            }

            $pieceOnTarget = $this->getPieceOnSquare($toRank, $toColumn  );
            if ($pieceOnTarget !== self::EMPTY_SQUARE) {
                if ($movingPiece->getColour() === $pieceOnTarget->getColour()) {
                    throw new InvalidMoveException("You cannot move onto a square occupied by your own piece");

                }

            }

            if ($movingPiece->getMoveType() == MoveTypeEnum::CASTLE) {
                if ($movingPiece->getColour() == ColourEnum::WHITE) {
                    if ($toColumn == 2) {
                        $rookColumn = 1;
                    } else {
                        $rookColumn = 8;
                    }

                }

                $rook = $this->getPieceOnSquare($toRank, $rookColumn);
                if ( ! $rook instanceof \PropertyLogic\Chess\Castle) {
                    throw new InvalidMoveException("You must have a Rook on square ({$toRank},{$rookColumn})");
                }
                if ($rook->hasMoved()) {
                    throw new InvalidMoveException("The rook on square ({$toRank},{$rookColumn}) has already moved this game");
                }
            }
            //------------------------------------------------------------
            // Refactor above code to use a rules class
            //   which means that
            //   1. pieces do not have to know about the state of the board
            //   2. the chessboard no longer requires knowledge of the pieces
            //------------------------------------------------------------
            $this->turn++;

            switch($movingPiece->getMoveType()) {
                case MoveTypeEnum::EN_PASSANT: {
                    throw new InvalidMoveException("NOT IMPLEMENTED MOVE EN PASSANT");
                    break;
                }
                case MoveTypeEnum::CASTLE: {
                    if ($toColumn == 2) {
                        $castleStart  = 1;
                        $castleFinish = 3;
                    } else {
                        $castleStart  = 8;
                        $castleFinish = 6;
                    }

                    $this->pieces[$fromRank][$castleStart]  = self::EMPTY_SQUARE;
                    $this->pieces[$fromRank][$castleFinish] = $rook;
                    
                    $rook->move($fromRank, $castleFinish);
                    $rook->setLastMove($this->turn);

                }
                default:
                case MoveTypeEnum::NORMAL: {
                    $this->pieces[$fromRank][$fromColumn] = self::EMPTY_SQUARE;
                    $this->pieces[$toRank  ][$toColumn  ] = $movingPiece;

            }
                
            }

            $movingPiece->move($toRank, $toColumn);
            $movingPiece->setLastMove($this->turn);

        } catch (InvalidMoveException $e) {
            // @todo find out why specific domain exception turned into generic
            throw new \Exception("Could not move that piece");

        }
        catch (exception $e) {
            // make sure an unexpected exception fails test
            throw new \Exception("Unexpected Exception");
        }

    }

    /**
     * @param int $rank
     * @param int $column
     * @return string
     * 
     * ? Is the square on the chess board ?
     */
    private function isValidSquare($rank, $column)
    {
        $result = '';

        if ( ($rank < 1) || ($rank > self::BOARD_LENGTH) ) {
            $result .= "bad rank {$rank} ";

        }
        if ( ($column < 1) || ($column > self::BOARD_LENGTH) ) {
            $result .= "bad column {$column}";

        }

        return $result;
    }

    /**
     * @param int $rank
     * @param int $column
     * @return Piece
     * Either a chess piece (Interface) or null (self::EMPTY_SQUARE)
     */
    public function getPieceOnSquare(int $rank, int $column): ?Piece
    {
        return $this->pieces[$rank][$column];
    }
}