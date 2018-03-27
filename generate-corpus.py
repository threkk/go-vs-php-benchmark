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


def run(tuples_file, x_file):
    with open(WORD_FILE) as rwf:
        all_words = rwf.read().splitlines()
        shuffle(all_words)

        words = all_words[:2000]
        assert len(words) == 2000

        ys = range(0, 5000)
        assert len(ys) == 5000

        values = ['%s %d x=%s,y=%d' % (x, y, x, y) for x in words for y in ys]
        assert len(values) == 10000000

        shuffle(values)

        with open(x_file, 'w') as wxf:
            for word in words:
                wxf.write('%s\n' % word)

        with open(tuples_file, 'w') as wtf:
            for value in values:
                wtf.write('%s\n' % value)


if __name__ == '__main__':
    parser = ArgumentParser(description=__doc__,
                            formatter_class=RawTextHelpFormatter)
    parser.add_argument('corpus', help='Name of the output file.', nargs='?',
                        default='corpus')
    args = parser.parse_args()
    corpus = args.corpus
    x = '%s-x' % corpus
    run(corpus, x)
