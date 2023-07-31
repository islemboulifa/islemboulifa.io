import os

from cs50 import SQL
from flask import Flask, flash, redirect, render_template, request, session
from flask_session import Session
from tempfile import mkdtemp
from werkzeug.security import check_password_hash, generate_password_hash

from helpers import apology, login_required, lookup, usd

# Description: Problem Set 9; a website via which users can “buy” and “sell” stocks.
# Date of Creation: 07/30/2023
# Programmer name: Islem Boulifa

# Configure application
app = Flask(__name__)

# Custom filter
app.jinja_env.filters["usd"] = usd

# Configure session to use filesystem (instead of signed cookies)
app.config["SESSION_PERMANENT"] = False
app.config["SESSION_TYPE"] = "filesystem"
Session(app)

# Configure CS50 Library to use SQLite database
db = SQL("sqlite:///finance.db")


@app.after_request
def after_request(response):
    """Ensure responses aren't cached"""
    response.headers["Cache-Control"] = "no-cache, no-store, must-revalidate"
    response.headers["Expires"] = 0
    response.headers["Pragma"] = "no-cache"
    return response


@app.route("/")
@login_required
def index():
    """Show portfolio of stocks"""
    user_id = session["user_id"]

    stocks = db.execute("SELECT symbol, price, shares FROM history WHERE user_id = ?", user_id)
    cash = db.execute("SELECT cash FROM users WHERE id = ?", user_id)[0]["cash"]

    sum_of_shares = db.execute("SELECT user_id, SUM(shares) as sum_of_shares FROM history WHERE user_id = ?",
    user_id)[0]["sum_of_shares"]

    prices = []
    for stock in stocks:
        quote = lookup(stock["symbol"])
        prices.append(quote["price"])

    return render_template("index.html", stocks = stocks, sum_of_shares = sum_of_shares, cash = cash, prices = prices)


@app.route("/buy", methods=["GET", "POST"])
@login_required
def buy():
    """Buy shares of stock"""

    # If it's a post request
    if request.method == "POST":
        symbol = request.form.get("symbol")
        quote = lookup(symbol)
        shares = request.form.get("shares")

        if not symbol:
            return apology("Input's blank", 400)
        if not quote:
            return apology("Symbol doesn't exist", 400)
        if shares.isdigit() != True or not shares or int(shares) < 1:
            return apology("Invalid number of shares", 400)


        user_id = session["user_id"]
        cash = db.execute("SELECT cash FROM users WHERE id = ?", user_id)[0]["cash"]
        price = quote["price"]
        payment = int(shares) * price
        new_cash = cash - payment

        if cash < payment:
            return apology("You are broke", 400)

        db.execute("UPDATE users SET cash = ? WHERE id = ?", new_cash, user_id)

        db.execute("INSERT INTO history(user_id, symbol, shares, price) VALUES (?, ?, ?, ?)",
        user_id, quote["symbol"], shares, payment)
        return redirect("/")

    else:
        # If it's a get request
        return render_template("buy.html")

@app.route("/sell", methods=["GET", "POST"])
@login_required
def sell():
    """Sell shares of stock"""
    user_id = session["user_id"]
    choices = db.execute("SELECT symbol FROM history WHERE user_id = ?", user_id)

    if request.method == "POST":
        symbol = request.form.get("symbol")
        shares_num = request.form.get("shares")

        if symbol == "x":
            return apology("Please Select a Symbol")
        if not shares_num:
            return apology("Please Select a valid number")

        shares = db.execute("SELECT shares FROM history WHERE user_id = ? AND symbol = ?", user_id, symbol)[0]["shares"]

        if  int(shares_num) < 1:
            return apology("Please select a number above 0")
        if int(shares_num) > int(shares):
            return apology("Not enough shares")

        # Update the History database (shares number and cash)

        db.execute("UPDATE history SET shares = shares - ? WHERE symbol = ? AND user_id = ?", int(shares_num), symbol, user_id)

        quote = lookup(symbol)['price']
        income = int(quote) * int(shares_num)

        db.execute("UPDATE users SET cash = cash + ? WHERE id = ?", income, user_id)

        return redirect("/")
    else:
        return render_template("sell.html", choices = choices)


@app.route("/history")
@login_required
def history():
    """Show history of transactions"""
    return apology("I really tried to finish all of it. My head was pretty dizzy, but i might finish it in the future.")


@app.route("/login", methods=["GET", "POST"])
def login():
    """Log user in"""

    # Forget any user_id
    session.clear()

    # User reached route via POST (as by submitting a form via POST)
    if request.method == "POST":

        # Ensure username was submitted
        if not request.form.get("username"):
            return apology("must provide username", 403)

        # Ensure password was submitted
        elif not request.form.get("password"):
            return apology("must provide password", 403)

        # Query database for username
        rows = db.execute("SELECT * FROM users WHERE username = ?", request.form.get("username"))

        # Ensure username exists and password is correct
        if len(rows) != 1 or not check_password_hash(rows[0]["hash"], request.form.get("password")):
            return apology("invalid username and/or password", 403)

        # Remember which user has logged in
        session["user_id"] = rows[0]["id"]

        # Redirect user to home page
        return redirect("/")

    # User reached route via GET (as by clicking a link or via redirect)
    else:
        return render_template("login.html")


@app.route("/logout")
def logout():
    """Log user out"""

    # Forget any user_id
    session.clear()

    # Redirect user to login form
    return redirect("/")


@app.route("/quote", methods=["GET", "POST"])
@login_required
def quote():
    """Get stock quote."""
    if request.method == "POST":
        symbol = request.form.get("symbol")
        quote = lookup(symbol)
        if not quote:
            return apology("Symbol doesn't exist", 400)
        return render_template("quoted.html", quote = quote)
    else:
        return render_template("quote.html")


@app.route("/register", methods=["GET", "POST"])
def register():
    if request.method == "GET":
        return render_template("register.html")

    # Handle the whole registration process
    else:
        username = request.form.get("username")
        password = request.form.get("password")
        confirmation = request.form.get("confirmation")

        if not username:
            return apology("Type username please", 400)
        if not password:
            return apology("Type password please", 400)
        if not confirmation:
            return apology("Password was not confirmed", 400)
        if password != confirmation:
            return apology("Passwords not matching", 400)

        # Query for username

        user = db.execute("SELECT COUNT(*) as count FROM users WHERE username = ?", username)

        if user[0]["count"] > 0:
            return apology("Username already in use", 400)

        hash = generate_password_hash(password)

        # add username to database after check
        db.execute("INSERT INTO users (username, hash) VALUES(?, ?)", username, hash)

        # get the id of the newly inserted user
        new_user_id = db.execute("SELECT id FROM users WHERE username = ?", username)

        session["user_id"] = new_user_id[0]["id"]

        return redirect("/")
