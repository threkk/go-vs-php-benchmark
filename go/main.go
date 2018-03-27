package main

import (
	"fmt"
	"os"
	"sort"
	"time"
)

const corpusRoute = "./corpus"
const xRoute = "./corpus-x"

var xs []string
var corpus []Tuple
var err error

func indexOf(arr []string, element string) int {
	for index, value := range arr {
		if value == element {
			return index
		}
	}
	return -1
}

func uniqueY(tuples []Tuple) []uint64 {
	keys := make(map[uint64]bool)
	uniq := make([]uint64, 0)
	for _, tuple := range tuples {
		if _, isset := keys[tuple.Y]; !isset {
			uniq = append(uniq, tuple.Y)
			keys[tuple.Y] = true
		}
	}
	return uniq
}

func init() {
	fmt.Printf("=> Importing the datasets.\n")
	xs = LoadX(xRoute)
	corpus, err = LoadCorpus(corpusRoute)
	if err != nil {
		fmt.Printf("Error loading the corpus.\n")
		os.Exit(1)
	}
}

func main() {
	fmt.Printf("=> Placing the elements in the intermediate table.\n")
	startSort := time.Now()

	// We calculate the amount of Y. Very much worth the computational cost.
	ys := uniqueY(corpus)

	// Size of the keys space is the same as the x's
	table := make(map[string]map[uint64]string, len(xs))
	for _, tuple := range corpus {
		_, isset := table[tuple.X]
		if !isset {
			table[tuple.X] = make(map[uint64]string, len(ys))
		}
		table[tuple.X][tuple.Y] = tuple.Value
	}

	sort.Strings(xs)
	diffSort := time.Since(startSort)
	fmt.Printf("=> Sorting finished.\n")

	fmt.Printf("=> Starting transpose of the table to its final form.\n")
	startTrans := time.Now()

	output := make([][]string, len(ys)+1)
	for i := range output {
		output[i] = make([]string, len(xs))
	}
	copy(output[0], xs)

	for x, yValue := range table {
		xIndex := indexOf(xs, x)

		if xIndex < 0 {
			panic(fmt.Errorf("Invalid value: %s", x))
		}

		for y, value := range yValue {
			output[y][xIndex] = value
		}
	}

	diffTrans := time.Since(startTrans)
	diffTotal := time.Since(startSort)
	fmt.Printf("=> Transpose finished!\n")

	fmt.Printf("\n")
	fmt.Printf("Total execution time: %f\n", diffTotal.Seconds())
	fmt.Printf("Sorting execution time: %f\n", diffSort.Seconds())
	fmt.Printf("Transpose execution time: %f\n", diffTrans.Seconds())
}
