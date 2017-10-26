<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono:400,400i,700,700i|VT323"
          rel="stylesheet">
    <title>Simple PHP Chess Engine</title>
    <style>
        body {
            font-family: 'Ubuntu Mono', monospace;
            margin: 40px;
        }

        h1 {
            font-family: 'Ubuntu Mono', monospace;
            font-weight: bold;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
            font-family: 'Ubuntu Mono', monospace;
            font-weight: bold;
            font-size: 24px;
        }

        td, tr {
            height: 60px;
            width: 60px;
        }

        td {
            position: relative;
        }

        td p {
            font-size: 12px;
            position: absolute;
            top: 0px;
            left: 0px;
            margin-top: 0px;

        }

        tr:nth-child(odd) td:nth-child(odd), tr:nth-child(even) td:nth-child(even) {
            background-color: black;
            color: white;
        }

        /*default version*/
        @font-face {
            font-family: 'chess-font';
            src: local('CASEFONT'),
            url('fonts/CASEFONT.TTF') format('truetype');
        }

        /*span elements inside the container div*/
        span {
            font-weight: bold;
        }

        /*container element*/
        .terminal, .header {
            background-color: black;
            color: lime;
            width: 60%;
            font-family: 'VT323', monospace;
            float: left;
            padding-left: 20px;
            margin-right: 20px;
            overflow-y: scroll;
        }

        .terminal h1 {
            font-weight: bold;
        }

        .terminal h2 {
            text-transform: capitalize;
        }

        .terminal h3 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .terminal {
            height: 600px;
        }

        .board {
            font-family: 'chess-font', sans-serif;
        }

    </style>
</head>
<body>
<div class="header">
    <h1>SIMPLE PHP CHESS ENGINE</h1><br>
</div>
<div class="terminal">
    <?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // STEPS:
    // Receive FEN
    // Convert FEN: Define board and piece positions
    // Render HTML board
    // Calculate moves for white
    // Caclulate responding moves for black

    $fenStartingPosition = 'rnbqkbnr/pppppppp/8/8/8/8/P1PPPPPP/RNBQKBNR';

    echo "<h2>FEN: $fenStartingPosition</h2>";

    $onus = "white";

    echo "<h2>$onus's Move</h2>";

    echo "<h3>PGN: </h3>";

    $board = array();

    /**
     * @param $fen
     * @return array
     */
    function fenConverter($fen)
    {
        // Purpose of function: Convert FEN to actual board positions and expose $whitePositions and $blackPositions
        global $board;
        $fenLength = strlen($fen);

        for ($i = 1; $i <= $fenLength; $i++)
        {
            //Get the first character using substr.
            $nextCharacter = substr($fen, $i - 1, 1);
            //echo $i . ": $nextCharacter<br />";
            if (ctype_alpha($nextCharacter))
            {
                array_push($board, $nextCharacter);
                //echo "piece";
            } elseif ($nextCharacter == "/")
            {
                // echo "nothing";
            } elseif ( ! ctype_alpha($nextCharacter))
            {
                //echo "spacing";
                for ($x = $nextCharacter; $x > 0; $x--)
                {
                    array_push($board, null);
                }
            }
        }

        array_unshift($board, "");
        unset($board[0]);

        function returnRank($key)
        {
            if ($key < 65 && $key > 56)
            {
                return 1;
            } elseif ($key < 57 && $key > 48)
            {
                return 2;
            } elseif ($key < 49 && $key > 40)
            {
                return 3;
            } elseif ($key < 41 && $key > 32)
            {
                return 4;
            } elseif ($key < 33 && $key > 24)
            {
                return 5;
            } elseif ($key < 25 && $key > 16)
            {
                return 6;
            } elseif ($key < 17 && $key > 8)
            {
                return 7;
            } elseif ($key < 9)
            {
                return 8;
            }
        }

        function returnFile($key)
        {
            $rank = fmod($key, 8);
            if ($rank == 1) {
                return 'a';
            } elseif ($rank == 2) {
                return 'b';
            } elseif ($rank == 3) {
                return 'c';
            } elseif ($rank == 4) {
                return 'd';
            } elseif ($rank == 5) {
                return 'e';
            } elseif ($rank == 6) {
                return 'f';
            } elseif ($rank == 7) {
                return 'g';
            } elseif ($rank == 8) {
                return 'h';
            }
        }

        $whitePositions = preg_grep("/[A-Z]/", $board);
        $blackPositions = preg_grep("/[a-z]/", $board);
        $emptyPositions = array_diff_key($board, $whitePositions, $blackPositions);

        $whitePawns = preg_grep("/[P]/", $whitePositions);
        $blackPawns = preg_grep("/[p]/", $blackPositions);

        $whiteBishops = preg_grep("/[B]/", $whitePositions);
        $blackBishops = preg_grep("/[b]/", $blackPositions);

        $whiteKnights = preg_grep("/[N]/", $whitePositions);
        $blackKnights = preg_grep("/[n]/", $blackPositions);

        $whiteRooks = preg_grep("/[R]/", $whitePositions);
        $blackRooks = preg_grep("/[r]/", $blackPositions);

        $whiteQueen = preg_grep("/[Q]/", $whitePositions);
        $blackQueen = preg_grep("/[q]/", $blackPositions);

        $whiteKing = preg_grep("/[K]/", $whitePositions);
        $blackKing = preg_grep("/[k]/", $blackPositions);


        echo "<h3>Board: </h3><p>";
        print_r($board);
        echo "</p><h3>Empty Positions: </h3><p>";
        print_r($emptyPositions);
        echo "</p><h3>White Positions: </h3><p>";
        print_r($whitePositions);
        echo "</p><h3>Black Positions: </h3><p>";
        print_r($blackPositions);

        echo "</p><h3>White Pawns: </h3><p>";
        print_r($whitePawns);
        echo "<h3>Possible Pawn Moves: <h3><p>";
        foreach ($whitePawns as $key => $value)
        {
            if (returnRank($key) == 2)
            {
                // Pawn Initial Move
                if (array_key_exists(($key - 16), $emptyPositions) && array_key_exists(($key - 8), $emptyPositions))
                {
                    echo "1.0 step";
                    echo $key . " to " . ($key - 16) . ", ";
                    echo $key . " to " . ($key - 8) . ", ";
                } elseif (array_key_exists(($key - 8), $emptyPositions))
                {
                    echo $key . " to " . ($key - 8) . ", ";
                }

                // Pawn NW & NE Attack
                if (array_key_exists(($key - 9), $blackPositions) && (returnfile($key) != 'a'))
                {
                    echo "1.1 step";
                    echo $key . " to attack" . ($key - 9) . ", ";
                } elseif (array_key_exists(($key - 7), $blackPositions))
                {
                    echo "1.2 step";
                    echo $key . " to attack" . ($key - 7) . ", ";
                }

            } elseif ($key < 49)
            {
                // Pawn's Move
                echo "2.0 step";
                echo $key . " to " . ($key - 8) . ", ";

            }
        }

        echo "</p><h3>Black Pawns: </h3><p>";
        print_r($blackPawns);
        echo "</p><h3>White Bishops: </h3><p>";
        print_r($whiteBishops);
        echo "<h3>Possible Bishop Moves: <h3><p>";
        foreach ($whiteBishops as $key => $value)
        {
            // Bishop's NW Diagonal
            if ((returnFile($key) != 'a') && array_key_exists(($key - 9), $emptyPositions))
            {
                echo $key . " to " . ($key - 9) . "";
                if ((returnFile($key) != 'a') && (returnFile($key) != 'b') && array_key_exists(($key - 18), $emptyPositions))
                {
                    echo ", " . $key . " to " . ($key - 18) . ", ";
                }
            }
        }
        echo "</p><h3>Black Bishops: </h3><p>";
        print_r($blackBishops);
        echo "</p><h3>White Knights: </h3><p>";
        print_r($whiteKnights);
        echo "</p><h3>Black Knights: </h3><p>";
        print_r($blackKnights);
        echo "</p><h3>White Rooks: </h3><p>";
        print_r($whiteRooks);
        echo "</p><h3>Black Rooks: </h3><p>";
        print_r($blackRooks);
        echo "</p><h3>White Queen: </h3><p>";
        print_r($whiteQueen);
        echo "</p><h3>Black Queen: </h3><p>";
        print_r($blackQueen);
        echo "</p><h3>White King: </h3><p>";
        print_r($whiteKing);
        echo "</p><h3>Black King: </h3><p>";
        print_r($blackKing);
        echo "</p>";

        echo "</div>";
    }

    function htmlBoard($board)
    {
        // Purpose of function: Render HTML version of board
        echo '<div class="ui">';
        echo '<table class="board"><tr>';

        for ($y = 1; $y < 65; $y++)
        {
            $square = $y;
            echo "<td data-square='$square'><p>$square</p>" . $board[ $y ] . "</td>";

            if ($y == 8 || $y == 16 || $y == 24 || $y == 32 || $y == 40 || $y == 48 || $y == 56)
            {
                echo "</tr><tr>";
            }
        }

        echo '</table></div><br />';
    }

    fenConverter($fenStartingPosition);

    function calculateMoves($var)
    {
        global $board;
        global $onus;
        global $color;

        /* Pawn */
        if ($color = "white")
        {
            return ($var == 'P');
        } else
        {
            return ($var == 'p');
        }

        function pawn($var, $color, $whitePositions, $blackPositions)
        {
            global $board;
            global $color;
            global $blackPositions;
            echo "<h3>Possible Pawn Moves: <h3><p>";
            print_r($pawnPositions);
        }

        function knight($var)
        {
            global $color;
            if ($color = "white")
            {
                return ($var == 'N');
            } else
            {
                return ($var == 'n');
            }
        }

        function bishop($var, $bishopPositions)
        {
            if ($var = "white")
            {
                return ($var == 'B');
            } else
            {
                return ($var == 'b');
            }
        }

        function rook($var, $rookPositions)
        {
            if ($var = "white")
            {
                return ($var == 'R');
            } else
            {
                return ($var == 'r');
            }
        }

        function queen($var, $queenPositions)
        {
            if ($var = "white")
            {
                return ($var == 'Q');
            } else
            {
                return ($var == 'q');
            }
        }

        function king($var, $kingPositions)
        {
            if ($var = "white")
            {
                return ($var == 'K');
            } else
            {
                return ($var == 'k');
            }
        }

        echo '</p></div>';
    }

    calculateMoves("white");
    htmlBoard($board);
    ?>
</body>
</html>

