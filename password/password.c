#include <cs50.h>
#include <stdio.h>
#include <ctype.h>
#include <string.h>

bool valid(string password);

int main(void)
{
    string password = get_string("Enter your password: ");
    if (valid(password))
    {
        printf("Your password is valid!\n");
    }
    else
    {
        printf("Your password needs at least one uppercase letter, lowercase letter, number and symbol\n");
    }
}

// TODO: Complete the Boolean function below
bool valid(string password)
{
    bool A, up = false, low = false, num = false, sym = false;

    for (int i = 0; i < strlen(password); i++)
    {

        if (islower(password[i]))
        {
        low = true;
        }
        else if (isupper(password[i]))
        {
        up = true;
        }
        else if (isdigit(password[i]))
        {
        num = true;
        }
        else if (ispunct(password[i]))
        {
        sym = true;
        }

    }
     if ( low & up & num & sym){
        A =true;
    }
    else{
        A = false;}
    return A;
}


