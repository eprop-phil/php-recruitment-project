<?php namespace PropertyLogic\Chess;

/**
 * @copyright Property Logic Ltd 2019.  All rights reserved.  This file may not be distributed without written consent
 * from Property Logic.
 */

class MoveTypeEnum extends BaseEnum
{
    const NORMAL = "normal";
    const CAPTURE = "capture";
    const CASTLE = "castle";
    const EN_PASSANT = "en passant";
}