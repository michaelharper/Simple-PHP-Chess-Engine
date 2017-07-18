<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Michael Harper: Simple Chess Engine</title>

    <link rel="stylesheet" href="../css/chessboard-0.3.0.css" />
    <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
            crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
    <script src="../js/chessboard-0.3.0.js"></script>
    <script src="../js/chess.js"></script>
</head>
<body>
<h1>Simple Chess Engine</h1>
<div id="board" style="width: 400px"></div>
<p>Status: <span id="status"></span></p>
<p>FEN: <span id="fen"></span></p>
<p>PGN: <span id="pgn"></span></p>

<script>
    var board,
        game = new Chess(),
        statusEl = $('#status'),
        fenEl = $('#fen'),
        pgnEl = $('#pgn');
    // do not pick up pieces if the game is over
    // only pick up pieces for the side to move
    var onDragStart = function (source, piece, position, orientation) {
        if (game.game_over() === true ||
            (game.turn() === 'w' && piece.search(/^b/) !== -1) ||
            (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
            return false;
        }
    };
    var onDrop = function (source, target) {
        // see if the move is legal
        var move = game.move({
            from: source,
            to: target,
            promotion: 'q' // NOTE: always promote to a queen for example simplicity
        });
        // illegal move
        if (move === null) return 'snapback';
        updateStatus();
    };
    // update the board position after the piece snap
    // for castling, en passant, pawn promotion
    var onSnapEnd = function () {
        board.position(game.fen());
    };
    var onChange = function(oldPos, newPos) {
        console.log("Position changed:");
        console.log("Old position: " + ChessBoard.objToFen(oldPos));
        console.log("New position: " + ChessBoard.objToFen(newPos));
        console.log("--------------------");
        console.log("transmit: " + ChessBoard.objToFen(newPos));
    };

    var onMoveEnd = function(oldPos, newPos) {
        console.log("Move animation complete:");
        console.log("Old position: " + ChessBoard.objToFen(oldPos));
        console.log("New position: " + ChessBoard.objToFen(newPos));
        console.log("--------------------");
    };
    var updateStatus = function () {
        var status = '';
        var moveColor = 'White';
        if (game.turn() === 'b') {
            moveColor = 'Black';
        }
        // checkmate?
        if (game.in_checkmate() === true) {
            status = 'Game over, ' + moveColor + ' is in checkmate.';
        }
        // draw?
        else if (game.in_draw() === true) {
            status = 'Game over, drawn position';
        }
        // game still on
        else {
            status = moveColor + ' to move';
            // check?
            if (game.in_check() === true) {
                status += ', ' + moveColor + ' is in check';
            }
        }
        statusEl.html(status);
        fenEl.html(game.fen());
        pgnEl.html(game.pgn());
    };
    var cfg = {
        draggable: true,
        position: 'start',
        onDragStart: onDragStart,
        onDrop: onDrop,
        onMoveEnd: onMoveEnd,
        onSnapEnd: onSnapEnd,
        onChange: onChange,
        sparePieces: true
    };
    board = ChessBoard('board', cfg);
</script>
</body>

</html>