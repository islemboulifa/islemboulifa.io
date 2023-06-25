// Description: Problem set 5 Speller; Implements a spell-checker
// Date of Creation: 06/09/2023
// Programmer name: Islem Boulifa

// Implements a dictionary's functionality

#include <ctype.h>
#include <stdbool.h>
#include <strings.h>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>

#include "dictionary.h"

// Represents a node in a hash table
typedef struct node
{
    char word[LENGTH + 1];
    struct node *next;
}
node;

// TODO: Choose number of buckets in hash table
const unsigned int N = 26;

// Hash table
node *table[N];

// Counter for dictionary words
unsigned int counter = 0;

// Returns true if word is in dictionary, else false
bool check(const char *word)
{
    int word_value = hash(word);
    node *cursor = table[word_value];
    // Compare the in-word with dictionary words
    while (cursor != NULL)
    {
        if (strcasecmp(word, cursor->word) == 0)
        {
            return true;
        }
        cursor = cursor->next;
    }
    return false;
}

// Hashes word to a number
unsigned int hash(const char *word)
{
    // this hash function was made by me, only 14% is not mine
    // so i would like to credit google search for letting me know
    // that its of great importance to use a modulo before returning a hash value
    // since it lowers chances of a collision and keep things within the range of our hash table
    unsigned int hash_value = 0;

    for (int i = 0; word[i] != '\0'; i++)
    {
        if (word[i] == '\'')
        {
            hash_value += (unsigned int)'\'';
        }
        else
        {
            hash_value += (unsigned int)tolower(word[i]);
        }
    }

    return hash_value % N;
}

// Loads dictionary into memory, returning true if successful, else false
bool load(const char *dictionary)
{
    // open dictionary file, return false in case of failure
    const char *infile = dictionary;
    FILE *dic = fopen(infile, "r");

    if (dic == NULL)
    {
        return false;
    }

    // store words from dictionary
    char dic_word[LENGTH + 1];

    while (fscanf(dic, "%s", dic_word) != EOF)
    {
        // Allocate memory and copy word into node

        node *n = malloc(sizeof(node));
        strcpy(n->word, dic_word);

        // Hash the word and get the word's hash number
        int hash_index = hash(dic_word);
        n->next = table[hash_index];
        table[hash_index] = n;

        counter++;
    }

    fclose(dic);

    return true;
}

// Returns number of words in dictionary if loaded, else 0 if not yet loaded
unsigned int size(void)
{
    // counter = 0 essentially mean that no word was read
    if (counter == 0)
    {
        return 0;
    }
    return counter;
}

// Unloads dictionary from memory, returning true if successful, else false
bool unload(void)
{
    for (int i = 0; i < N; i++)
    {
        node *head = table [i];
        node *cursor = head;
        node *temp = head;
        // cursor moves a step forward while temp is still pointing
        // to the previous node, which allows us to free temp without
        // losing the other nodes.
        // repeat until cursor equal to NULL
        while (cursor != NULL)
        {
            cursor = cursor->next;
            free(temp);
            temp = cursor;
        }
    }

    return true;
}
