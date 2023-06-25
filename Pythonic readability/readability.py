# Description: Problem Set 2 Readability; computes the approximate grade level needed to comprehend a text
# Date of Creation: 06/16/2023
# Programmer name: Islem Boulifa

import string

def main():

    text = input("Text: ")
    letters = int(count_letters(text))
    words = int(count_words(text))
    sentences = int(count_sentences(text))

    # This is the formula for our index
    calculate = float((0.0588 * letters / words * 100) - (0.296 * sentences / words * 100) - 15.8)

    # Rounded version of our index
    index = round(calculate)

    # put what ever grade it is, as long as:
    # it's not greater or equal to 16, or less than 1
    if index < 1:
        print("Before Grade 1\n")
    elif index >= 16:
        print("Grade 16+\n")
    else:
        print(f"Grade {index}")


def count_letters(letters):
    counter = 0
    for i in range(len(letters)):

        # Finding a letter is enough to count it as a letter
        # isalpha() captures both upper and lower cases
        if letters[i].isalpha():
            counter += 1
        else:
            counter += 0

    return counter


def count_words(words):

    # split method sperates words into a list, based on white spaces
    # and len will count those seperated words
    counter = len(words.split())
    return counter


def count_sentences(sentences):
    counter = 0
    for i in range(len(sentences)):

        # So as long as there is one of the three punctuation, a sentence will be counted
        c = sentences[i]
        if c in ['.', '!', '?']:
            counter += 1

    return counter


main()