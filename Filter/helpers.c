#include "helpers.h"
#include <math.h>
// Description: Problem set 4 Filter-less
// Date of Creation: 06/06/2023
// Programmer name: Islem Boulifa

// Convert image to grayscale
void grayscale(int height, int width, RGBTRIPLE image[height][width])
{
    for (int i = 0; i < height; i++)
    {
        for (int j = 0; j < width; j++)
        {
            // Adds the RGB colors value together and devide by 3 to get the average number for a grey scale
            float calc = (image[i][j].rgbtRed + image[i][j].rgbtGreen + image[i][j].rgbtBlue);
            calc = round(calc/3);
            int average = calc;
            image[i][j].rgbtBlue = average;
            image[i][j].rgbtGreen = average;
            image[i][j].rgbtRed = average;
        }
    }
    return;
}

// Convert image to sepia
void sepia(int height, int width, RGBTRIPLE image[height][width])
{
     for (int i = 0; i < height; i++)
    {
        for (int j = 0; j < width; j++)
        {

            float sepiaRed = (.393 * image[i][j].rgbtRed + .769 * image[i][j].rgbtGreen + .189 * image[i][j].rgbtBlue);
            float sepiaGreen = (.349 * image[i][j].rgbtRed + .686 * image[i][j].rgbtGreen + .168 * image[i][j].rgbtBlue);
            float sepiaBlue = (.272 * image[i][j].rgbtRed + .534 * image[i][j].rgbtGreen + .131 * image[i][j].rgbtBlue);

            if (sepiaRed > 255)
            {
                sepiaRed = 255;
            }

            if (sepiaGreen > 255)
            {
                sepiaGreen = 255;
            }

            image[i][j].rgbtBlue = round(sepiaBlue);
            image[i][j].rgbtGreen = round(sepiaGreen);
            image[i][j].rgbtRed = round(sepiaRed);;
        }
    }
    return;
}


// Blur image
void blur(int height, int width, RGBTRIPLE image[height][width])
{
     // A temporary struct to hold the blurred result
     RGBTRIPLE temp[height][width];

    // Iterate over each pixel in the image
    for (int i = 0; i < height; i++)
    {
        for (int j = 0; j < width; j++)
        {
            int sumR = 0;
            int sumG = 0;
            int sumB = 0;
            int pixels = 0;

            // Loop that iterate over the neighboring pixels of the current pixel
            for (int k = -1; k <= 1; k++)
            {
                for (int l = -1; l <= 1; l++)
                {
                    // Check if the neighboring pixel is within the image boundary
                    if (i + k >= 0 && i + k < height && j + l >= 0 && j + l < width)
                    {
                        sumR += image[i + k][j + l].rgbtRed;
                        sumG += image[i + k][j + l].rgbtGreen;
                        sumB += image[i + k][j + l].rgbtBlue;
                        pixels++;
                    }
                }
            }
            // Calculate the average color values for the current pixel
            temp[i][j].rgbtRed = round((float)sumR / pixels);
            temp[i][j].rgbtGreen = round((float)sumG / pixels);
            temp[i][j].rgbtBlue = round((float)sumB / pixels);
        }
    }

    // Copy temp back to the original image
    for (int i = 0; i < height; i++)
    {
        for (int j = 0; j < width; j++)
        {
            image[i][j] = temp[i][j];
        }
    }
    return;
}
