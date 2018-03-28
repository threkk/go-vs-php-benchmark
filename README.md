# Go vs PHP: a benchmark in a real business case.
> Aiming to benchmark the difference in performance between Go and PHP given a
> common problem to solve and using similar algorithms.

## The problem 
The problem aims to emulate an existing real business case which has been
abstracted into a simple sorting problem.

Given a list of tuples with values `(x, y, z)`, sort them in a matrix
structure like:

```
   |  x1 |  x2 |  x3 |
y1 | z11 | z21 | z31 |
y2 | z12 | z22 | z32 |
y3 | z13 | z23 | z33 |
```
The end result is a valid CSV output.

In order to simulate the business case, the data has to be formated in three different ways:

1. `[(x1, y1, z11), (x2, y2, z22), (x3, y3, z33)]`
2. `[x1 => [y1 => z11, y2 => z12], x2 => [y1 => z21, y2 => z22]]`
3. `[ [x1, x2, x3], [z11, z21, z31], [z12, z22, z32], [z13, z23, z33] ]`

## Requirements
- Only standard library.
- The `x` are `string` values while `y` are `integer`. The value of `z` is
  irrelevant for the case.
- The `x` values are 200 random words. The `y` values are 500 random numbers. In
  total, there will be 100000 tuples.
- The `x` values are already known.
- The list of tuples is shuffled.

## How to run (and some results)
```
$ python3 generate-corpus.py -x 2000 -y 5000
Total amount of x values: 2000
Total amount of y values: 5000
Total amount of tuples: 10000000
$ php php/main.php
=> Importing datasets.
=> Placing the elements in the intermediate table.
=> Sorting finished!
=> Starting transpose of the table to its final form.
=> Transpose finished!
=> Ensuring the validity of the table

Total execution time: 245.74692201614
---
Sorting execution time: 168.59820103645
Transpose execution time: 68.297261953354
Check execution time: 8.8513069152832
$ go run go/main.go go/loader.go
=> Importing the datasets.
=> Placing the elements in the intermediate table.
=> Sorting finished.
=> Starting transpose of the table to its final form.
=> Transpose finished!
=> Ensuring the validity of the table.

Total execution time: 8.476577
---
Sorting execution time: 4.507947
Transpose execution time: 0.294785
Check execution time: 3.673732
```
