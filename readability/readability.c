#include <ctype.h>
#include <cs50.h>
#include <stdio.h>
#include <string.h>
#include <math.h>
// Description: Problem Set 2 Readability
// date of Creation: 05/31/2023
// Programmer name: Islem Boulifa

int count_letters(string letters);
int count_words(string words);
int count_sentences(string sentences);
int main(void)

{
    string text = get_string("Text: ");
    int letters = count_letters(text);
    int words = count_words(text);
    int sentences = count_sentences(text);
    // This is the formula for our index
    float calculate = (0.0588 * letters / words * 100) - (0.296 * sentences / words * 100) - 15.8;
    // Rounded version of our index
    int index = round(calculate);

    // We can put what ever grade it is, as long as:
    // it's not greater or equal to 16, or less than 1
    if (index < 1)
    {
        printf("Before Grade 1\n");
    }
    else if (index >= 16)
    {
        printf("Grade 16+\n");
    }
    else
    {
        printf("Grade %d\n", index);
    }

}

int count_letters(string letters)
{
    string alpha = letters;
    int counter = 0;
    for (int i = 0; i < strlen(letters); i++)
    {
        // Finding a letter is enough to count it as a letter
        // isalpha() captures both upper and lower cases
        if (isalpha(alpha[i]) == 0)
        {
            counter += 0;
        }
        else
        {
            counter ++;
        }
    }
    return counter;
}

int count_words(string words)
{
    string alpha = words;
    // There has to be at least one word, thus counter is set to the initial value of 1
    int counter = 1;
    // Made in a way so that it doesn't count the dash and letters
    // In other words; for a word to count, program needs to find a space
    for (int i = 0; i < strlen(words); i++)
    {
        char c = alpha[i];
        if (ispunct(c) == 0 && c != '-' && isalpha(c) == 0)
        {
            counter ++;
        }
        else
        {
            counter += 0;
        }
    }
    return counter;
}

int count_sentences(string sentences)
{
    string alpha = sentences;
    int counter = 0;

    for (int i = 0; i < strlen(sentences); i++)
    {
        // So as long as there is one of the three punctuation, a sentence will be counted
        char c = alpha[i];
        if (c == '.' || c == '!' || c == '?')
        {
            counter ++;
        }
        else
        {
            counter += 0;
        }
    }
    return counter;
}
a