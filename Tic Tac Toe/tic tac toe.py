print('Tic Tac Toe 1.0 !\n')

board = {f'p{i}': i for i in range(1, 10)}
end = False
turn = 0

print(f'|{board["p1"]}|{board["p2"]}|{board["p3"]}|')
print(f'|{board["p4"]}|{board["p5"]}|{board["p6"]}|')
print(f'|{board["p7"]}|{board["p8"]}|{board["p9"]}|\n')

# end the game when necessary
def winning(board):
    if (board["p1"] == board["p2"] == board["p3"])\
        or (board["p4"] == board["p5"] == board["p6"])\
        or (board["p7"] == board["p8"] == board["p9"])\
        or (board["p1"] == board["p4"] == board["p7"])\
        or (board["p2"] == board["p5"] == board["p8"]) \
        or (board["p3"] == board["p6"] == board["p9"])\
        or (board["p1"] == board["p5"] == board["p9"])\
        or (board["p3"] == board["p5"] == board["p7"]):
        return True
    elif turn > 8:
        return True

    return False

while not end:
    try:
        choice = int(input('Choose a number: '))

        # check if the spot chosen is valid
        while choice not in range(1, 10):
            choice = int(input("put a valid number: "))

        # check if the spot chosen is available
        while board[f'p{choice}'] == "O" or board[f'p{choice}'] == "X":
            choice = int(input("this spot is taken!\nChoose another number: "))

    except (ValueError, KeyError):
        print("put a valid number: ")
    else:
        # Determine who's turn it is
        if (turn % 2) == 0:
            if board[f'p{choice}'] != "X" and board[f'p{choice}'] != "O":
                board[f'p{choice}'] = "X"
            else:
                print("This spot is taken! Choose another number.")
                continue
        else:
            if board[f'p{choice}'] != "X" and board[f'p{choice}'] != "O":
                board[f'p{choice}'] = "O"
            else:
                print("This spot is taken! Choose another number.")
                continue
        turn += 1

    print(f'\n|{board["p1"]}|{board["p2"]}|{board["p3"]}|')
    print(f'|{board["p4"]}|{board["p5"]}|{board["p6"]}|')
    print(f'|{board["p7"]}|{board["p8"]}|{board["p9"]}|\n')

    end = winning(board)

# Check game's Winner
if turn == 9:
    print("it's a Tie")
elif turn % 2 == 1:
    print('###########################\n'
          '# Winner is: player 1 (X) #\n'
          '###########################')
else:
    print('###########################\n'
          '# Winner is: player 2 (O) #\n'
          '###########################')
