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
