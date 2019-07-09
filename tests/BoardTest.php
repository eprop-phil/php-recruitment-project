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
use PropertyLogic\Chess\ColourEnum;
use PropertyLogic\Chess\InvalidMoveException;

final class BoardTest extends TestCase
{

    /**
     * @test
     * ? can we add a king below 1st rank ?
     */
    public function testCannotAddPieceToBadRow0()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 0,4);

    }

    /**
     * @test
     * ? can we add a king after last row ?
     */
    public function testCannotAddPieceToBadRow9()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 4,9);

    }

    /**
     * @test
     * ? can we add a king before 1st column ?
     */
    public function testCannotAddPieceToBadColumn0()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 4, 0);

    }

    /**
     * @test
     * ? can we add a king aftet last column ?
     */
    public function testCannotAddPieceToBadColumn9()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 4, 9);

    }

    /**
     * @test
     * ? can we move white king from 1st to 2nd rank ?
     */
    public function testMoveKingPositive()
    {
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 1,4);
        $board->movePiece(1,4 , 1,5);
        $pieceAtTarget = $board->getPieceOnSquare(1,5);
        $pieceAtSource = $board->getPieceOnSquare(1,4);
        $this->assertEquals($king, $pieceAtTarget);
        $this->assertNull($pieceAtSource);
    }

    /**
     * @test
     * ? can we move below 1st rank ?
     */
    public function testMoveKingBadRow0()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 1, 4);
        $board->movePiece(1,4 , 0,4);

    }
    /**
     * @test
     * ? can we move after last rank ?
     */
    public function testMoveKingBadRow9()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 8,4);
        $board->movePiece(8,4 , 9,4);

    }

    /**
     * @test
     * ? can we move before 1st column ?
     */
    public function testMoveKingBadColumn0()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 1,1);
        $board->movePiece(1,1 , 1,0);

    }

    /**
     * @test
     * ? can we move after last column ?
     */
    public function testMoveKingBadColumn9()
    {
        $this->expectException(\Exception::class);
        
        $board = new Chessboard();
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board->addPiece($king, 1,8);
        $board->movePiece(1,8 , 1,9);

    }

    /**
     * @test
     * ? check all legal king moves on an empty board
     */
    public function testAllLegalMoves()
    {
        $king = new King();
        $king->setColour(new ColourEnum(ColourEnum::WHITE));
        $board = new Chessboard();

        $board->addPiece($king, 1,3); // start
        $board->movePiece(1,3 , 2,4); // / ne
        $board->movePiece(2,4 , 3,4); // | north up
        $board->movePiece(3,4 , 4,3); // \ nw
        $board->movePiece(4,3 , 4,2); // - west left
        $board->movePiece(4,2 , 3,1); // / sw
        $board->movePiece(3,1 , 2,1); // | down
        $board->movePiece(2,1 , 1,2); // \ se
        $board->movePiece(1,2 , 1,3); // - east right// back to starting square
        
        $this->assertEquals($king, $board->getPieceOnSquare(1,3));

        $this->assertNull($board->getPieceOnSquare(2,4));
        $this->assertNull($board->getPieceOnSquare(3,4));
        $this->assertNull($board->getPieceOnSquare(4,3));
        $this->assertNull($board->getPieceOnSquare(4,2));
        $this->assertNull($board->getPieceOnSquare(3,1));
        $this->assertNull($board->getPieceOnSquare(2,1));
        $this->assertNull($board->getPieceOnSquare(1,2));

    }

}