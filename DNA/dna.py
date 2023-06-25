# Description: Problem Set 6 DNA; identifies a person based on their DNA
# Date of Creation: 06/21/2023
# Programmer name: Islem Boulifa


import csv
import sys


def main():

    # Check for command-line usage
    if len(sys.argv) != 3:
        sys.exit("Usage: python dna.py data.csv sequence.txt")

    # Read database file into a variable
    database = []
    argv = sys.argv[1]
    with open(argv, 'r') as data:
        file_reader = csv.DictReader(data)
        for line in file_reader:
            database.append(line)

    # Read DNA sequence file into a variable
    argdna = sys.argv[2]
    dna = open(argdna, 'r')
    sequence = dna.read()

    # Find longest match of each STR in DNA sequence

    AGATC = longest_match(sequence, "AGATC")
    AATG = longest_match(sequence, "AATG")
    TATC = longest_match(sequence, "TATC")

    # TODO: Check database for matching profiles

    for line in database:

        if line['AGATC'] == str(AGATC) and line['AATG'] == str(AATG) and line['TATC'] == str(TATC):
            print(line["name"])
            return  # Print name if found a match and exit program

    print("no match")


def longest_match(sequence, subsequence):
    """Returns length of longest run of subsequence in sequence."""
    # Initialize variables
    longest_run = 0
    subsequence_length = len(subsequence)
    sequence_length = len(sequence)

    # Check each character in sequence for most consecutive runs of subsequence
    for i in range(sequence_length):

        # Initialize count of consecutive runs
        count = 0

        # Check for a subsequence match in a "substring" (a subset of characters) within sequence
        # If a match, move substring to next potential match in sequence
        # Continue moving substring and checking for matches until out of consecutive matches
        while True:

            # Adjust substring start and end
            start = i + count * subsequence_length
            end = start + subsequence_length

            # If there is a match in the substring
            if sequence[start:end] == subsequence:
                count += 1

            # If there is no match in the substring
            else:
                break

        # Update most consecutive matches found
        longest_run = max(longest_run, count)

    # After checking for runs at each character in seqeuence, return longest run found
    return longest_run


main()
