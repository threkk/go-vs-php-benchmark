package main

import (
	"fmt"
)

func main() {
	fmt.Print("Hi")
	x := LoadX("../corpus-x")
	fmt.Print(x)
	corpus, _ := LoadCorpus("../corpus")
	fmt.Print(corpus)
}
