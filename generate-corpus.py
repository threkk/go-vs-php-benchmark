#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Generates a random corpus for the benchmark.\n\n

The output of the script are two files, with the following names by default:

    corpus - Contains the tuples of the corpus. Each line is a different tuple
    with the format "x y value".

    corpus-x - Contains the x values of the corpus.

In order to generate the words, it uses FreeBSD's dictionary, which can be
found in /usr/share/dict/words in most of Linux distributions and OSX (Windows
not supported).
"""
from random import shuffle
from argparse import ArgumentParser
from argparse import RawTextHelpFormatter

# Dictionary path.
WORD_FILE = '/usr/share/dict/words'


def run(tuples_file, x_file, len_x, len_y):
    with open(WORD_FILE) as rwf:
        all_words = rwf.read().splitlines()
        shuffle(all_words)

        words = all_words[:len_x]
        assert len(words) == len_x

        ys = range(0, len_y)
        assert len(ys) == len_y

        values = ['%s %d x=%s,y=%d' % (x, y, x, y) for x in words for y in ys]
        assert len(values) == len_x * len_y

        shuffle(values)

        with open(x_file, 'w') as wxf:
            for word in words:
                wxf.write('%s\n' % word)

        with open(tuples_file, 'w') as wtf:
            for value in values:
                wtf.write('%s\n' % value)

        print('Total amount of x values: %d' % len(words))
        print('Total amount of y values: %d' % len(ys))
        print('Total amount of tuples: %d' % len(values))


if __name__ == '__main__':
    parser = ArgumentParser(description=__doc__,
                            formatter_class=RawTextHelpFormatter)
    parser.add_argument('-x', '--x', metavar='x', action='store', default=2000,
                        type=int, help='Amount of words to use. Default: 2000')
    parser.add_argument('-y', '--y', metavar='y', action='store', default=5000,
                        type=int, help='Amount of y elements. Default: 5000')
    parser.add_argument('corpus', default='corpus', nargs='?',
                        help='Name of the output file.')
    args = parser.parse_args()
    corpus = args.corpus
    x = args.x
    y = args.y
    corpus_x = '%s-x' % corpus
    run(corpus, corpus_x, x, y)
