<?php

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

declare(strict_types=1);

error_reporting(E_ALL);

use PHPUnit\Framework\TestCase;
use PropertyLogic\Chess\Chessboard;
use PropertyLogic\Chess\King;
use PropertyLogic\Chess\Castle;
use PropertyLogic\Chess\ColourEnum;

final class KingTest extends TestCase
{

    public function testCannotMoveOntoSameSquare()
    {
        $this->expectException(\Exception::class);

        $this->doMove(4,4 , 4,4);
        
    }

    /**
     * TODO:
     *   1. Fix or improve this test.
     *   2. Implement the functions to get it to pass.
     *
     * The king should not be able to move more than one square at a time.
     * This test should check a number of different combinations of moving the king.
     *
     */
    public function testCannotMoveMoreThanOneSquare()
    {
        try {
            $this->doMove(4,4 , 4,6);

        }
        catch(Exception $e) {
            $this->assertEquals($e->getMessage(), 'Could not move that piece');

        }

        try {
            $this->doMove(4,6 , 1,1);

        }
        catch(Exception $e) {
            $this->assertEquals($e->getMessage(), 'Could not move that piece');

        }

        try {
            $this->doMove(1,1 , 6,3);

        }
        catch(Exception $e) {
            $this->assertEquals($e->getMessage(), 'Could not move that piece');

        }

    }

    /**
     * 
     * 
     */
    public function doMove(int $fromRank, int $fromColumn, int $toRank, int $toColumn)
    {
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::BLACK));
        $board = new Chessboard();
        $board->addPiece($king, $fromRank, $fromColumn);

        $board->movePiece($fromRank,$fromColumn, $toRank,$toColumn);
    }

    /**
     * Implement code to get this test to pass.
     *
     * The king must be allowed to castle if:
     * 1) It has not moved
     * 2) There is a castle which has not moved at the end of the board in the direction of castling
     * 3) There are no pieces between the king and the castle
     * 4) The king does not move through, out of of, or into check (no need to implement this test for this project)
     */
    public function testThatKingIsAllowedToCastle()
    {
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));

        $rook = new Castle();
        $rook->setColour(new ColourEnum(ColourEnum::WHITE));
       
        $board = new Chessboard();
        $board->addPiece($king, 1,4);
        $board->addPiece($rook, 1,1);

        $board->movePiece(1,4, 1,2);
        //echo "\n###\n".print_r($board->getPieceOnSquare(1,1),true)."\n###\n";

        $this->assertEquals(null,  $board->getPieceOnSquare(1,1));
        $this->assertEquals($king, $board->getPieceOnSquare(1,2));
        $this->assertEquals($rook, $board->getPieceOnSquare(1,3));
        $this->assertEquals(null,  $board->getPieceOnSquare(1,4));
    }

    public function testThat_King_NotAllowedToCastleIf_Rook_HasMoved()
    {
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));

        $rook = new Castle();
        $rook->setColour(new ColourEnum(ColourEnum::WHITE));
       
        $board = new Chessboard();
        $board->addPiece($king, 1,4);
        $board->addPiece($rook, 1,2);

        $board->movePiece(1,2, 1,1); // ensure rook move count increments from 0

        try {
            $this->doMove(1,4 , 1,2);

        }
        catch(Exception $e) {
            $this->assertEquals($e->getMessage(), 'Could not move that piece');

        }

    }
}