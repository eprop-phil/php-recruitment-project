<?php

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PropertyLogic\Chess\Chessboard;
use PropertyLogic\Chess\King;
use PropertyLogic\Chess\ColourEnum;

final class BoardTest extends TestCase
{

    public function testMoveKingPositive()
    {
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 4, 1);
        $board->movePiece(4, 1, 5, 1);
        $pieceAtTarget = $board->getPieceOnSquare(5,1);
        $pieceAtSource = $board->getPieceOnSquare(4,1);
        $this->assertEquals($king, $pieceAtTarget);
        $this->assertNull($pieceAtSource);
    }

}