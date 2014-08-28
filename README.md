# pesto
Pesto is an insanely simple, minimal, lightweight blogging platform.

# why?
Originally, I wrote [Basil](http://www.github.com/freefouran/basil). The platform was very simple, although, I considered Basil to be a project to get me into PHP. Now I know a bit more about PHP, there are a lot of things I've wanted to change, and improve, thus Pesto was born.

# why should I use this over [Basil](http://www.github.com/freefouran/basil)?
I wrote Basil as a small starter project for getting into PHP. Over the past few months
I've become a lot more proficient in PHP, so the code is a lot more cleaner, and efficient.
Also, I've added various extra features, these include:

	* Proper truncation of blog posts, so no leaking HTML
	* A cleaner design
	* Posts are written in Markdown
	* Infinite scrolling instead of loading all the blog posts at once
	* Subjects so you can filter through blog posts, and show what you're talking about

That's the majority of the bigger differences between Basil and Pesto, 

# authors
* Felix

# requirements
There are a few things you will need for using Pesto.

* PHP 5.3.7 or above
* MySQL 4 or above
* A database

It is very important that you have PHP >= 5.3.7 This is because we use a library called password_compat for password hashing/encryption!

As for MySQL it's not as important, although you should have some knowledge of how to create a database. Table creation, and all the other MySQL related stuff is done for you.
