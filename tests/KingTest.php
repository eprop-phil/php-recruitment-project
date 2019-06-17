<?php

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use PropertyLogic\Chess\Chessboard;
use PropertyLogic\Chess\King;
use PropertyLogic\Chess\ColourEnum;

final class KingTest extends TestCase
{

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
        $this->expectException(\Exception::class);
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::BLACK));
        $board = new Chessboard();
        $board->addPiece($king, 4, 4);
        $board->movePiece(4,4, 4, 6);
        $board->movePiece(4,6, 1, 1);
        $board->movePiece(1,1, 6, 3);
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
        $board = new Chessboard();
        $board->addPiece($king, 1, 4);
        $board->movePiece(1,4, 1, 2);
        $this->assertTrue(true);
    }

}