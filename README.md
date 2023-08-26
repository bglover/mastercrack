# MasterCrack
<pre>
             _,,....,,_
          ,:`,11fLG1i:;;`.
        ,,101,:ti:;i::f0i;:          A PHP class to calculate the
       ,,0t::         :,C01i         combination for a masterlock.
      :;0t:             :f01;
     iLGL;               t0Li,       Uses a technique by <a href=http://null-byte.wonderhowto.com/how-to/crack-any-master-combination-lock-8-tries-less-using-calculator-0161629/">Samy Kamkar</a>
     tL0L1               1L01;
     1L0Li               iL8f;
     tL0L;               iL0L;
     tL0L;               iL8Li
     1L01t.:..,::,i1::;i,:,8Li
     iL,:1:;1tt:;;;,CCf1iiiiLi
    .,it1t;,,.,if0fi:,;;iii11:.
   ,:t,,,,t00tG;G;G;G1GGtii;1fti
  :f;,,10f0LGGGGGfGGGGC0LG0t;i1t1
 1f;.;GGiG0L0GGGLiGGG0000fG0Gti1t1
:Ltit80C0:ftt0CCCGGG000C1G8880ti1f,
tL1f088800LCLLGLCCCG8GC880808G0t1f1
LtttG888888 ~~~~~~~~~~~ 888880Gt111
:ttC008:i00 MASTERCRACK 0tLC0GCCii:
.::LGC0:fGG ~~~~~~~~~~~ GG:1GLGL;:.
 ,:i8LCGGGCCCGGGGGGGGG0GGGGGG18i::
  ,:f0:GGLfCGGGGGGGGGGGt1GGG,0L::
   ,:f8;GCfLfGGGGG0GG0i;;LGt81;:
     ::GCG;GGGGGGfLG0000GG0C;i
       ,;f8f0t0G0:010i0t8fii
         '.ii1LG888GLii1:'
</pre>


## Installation

### Prerequisites

MasterCrack requires PHP 5.4 or higher.


### Composer (directly)

The easiest way to install this tool is via composer

``` shell
composer require access9/mastercrack
```


### Composer (via your composer.json)

Add the following to your composer.json

``` json
"access9/mastercrack": "*"
```

#### When either of the two composer installation methods completes, you can run mastercrack with:

``` shell
vendor/bin/mastercrack
```


### Cloning

Of course you can always clone the repository:

``` shell
git clone https://github.com/bglover/mastercrack.git
```

Make sure you get the required vendor dependencies using composer:

``` shell
composer update -o --prefer-dist
```


# Usage

```shell
vendor/bin/mastercrack

1. Find the "First Locked Position"
  1. Set the dial to 0.
  2. Apply full pressure upward on the shackle as if trying to open it.
  3. Rotate dial to the left (towards 10) hard until the dial gets locked.
  4. Notice how the dial is locked into a small groove.
     a. If you're directly between two digits such as 3 and 4,
        release the shackle and turn the dial left further until
        you're into the next locked groove.
     b. However, if the dial is between two half digits (e.g., 2.5 and 3.5),
        then enter the digit in-between (e.g., 3) into First Locked Position below.

First Locked Position: 4

2. Find the "Second Locked Position"
  Do all of the above again until you find the second digit below 11 that is
  between two half digits (e.g., 5.5 and 6.5), and enter the whole number (e.g., 7)
  into Second Locked Position below.

Second Locked Position: 7

3. Find the "Resistant Location"
  1. Apply half as much pressure to the shackle so that you can turn the dial.
  2. Rotate dial to the right until you feel resistance.
     - Rotate the dial to the right several more times to ensure you're feeling
       resistance at the same exact location.
  3. Enter this number into Resistant Location below.
     - If the resistance begins at a half number, such as 14.5, enter 14.5.

Resistant Location: 27

First:  32
Second: 2, 6, 10, 14, 18, 22, 26, 30, 34, 38
Third:  4, 24
```

# Credits
Only the PHP code was written by me. The formula and help text were taken from the website [How to crack any master combination lock in 8 tries or less](http://null-byte.wonderhowto.com/how-to/crack-any-master-combination-lock-8-tries-less-using-calculator-0161629)
