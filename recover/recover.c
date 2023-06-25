#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

// Description: Problem Set 4 Recover
// date of Creation: 06/07/2023
// Programmer name: Islem Boulifa

#define memory_size 512

int main(int argc, char *argv[])
{
    // Accept exactly one command-line argument
    if (argc != 2)
    {
        printf("Usage: ./recover IMAGE\n");
        return 1;
    }

    char *infile = argv[1];
    FILE *image = fopen(infile, "r");
    // Check if File is valid and openable
    if (image == NULL)
    {
        printf("Could not open %s.\n", infile);
        return 1;
    }

    FILE *outfile = NULL; // Pointer to the last jpg
    unsigned char buffer[memory_size];
    int file_count = 0;
    bool image_found = false;

    // Make sure that it goes through whole block
    while (fread(buffer, sizeof(unsigned char), memory_size, image) == memory_size)
    {
        // Check for jpeg signature
        // Assuming the four first signatures are the four first element of a memory block
        if (buffer[0] == 0xff && buffer[1] == 0xd8 && buffer[2] == 0xff && (buffer[3] & 0xf0) == 0xe0)
        {
            if (image_found)
            {
                // Close the previous file if a jpeg is already found
                fclose(outfile);
            }
            else
            {
                image_found = true;
            }

            // Create a new jpeg file
            char filename[8];
            sprintf(filename, "%03d.jpg", file_count);
            outfile = fopen(filename, "w");

            // Write from buffer to the current jpeg file
            fwrite(buffer, sizeof(unsigned char), memory_size, outfile);


            file_count++;
        }
        else if (image_found)
        {
            // Continue writing to the current jpeg file
            fwrite(buffer, sizeof(unsigned char), memory_size, outfile);
        }

    }
    // Close every file
    fclose(outfile);
    fclose(image);

    return 0;
}
