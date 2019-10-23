import sys


def calculation(n1, n2):
    answer = n1 + n2
    print(answer)


######################################################
################### main function ####################
######################################################
def main():
    list = ["init", "filetest", "restore", "store <filename>",
            "backuplist <filename/pattern>", "get <filename/pattern>"]

    item = None
    function = None
    if (len(sys.argv) < 2):
        print("\nno function name detected, valid functions:")
        for i in list:
            print(">" + i)
    else:
        function = sys.argv[1]
    if function == "calculation":
        if len(sys.argv) < 4:
            print(sys.argv[2])
        else:
            num1 = int(sys.argv[2])
            num2 = int(sys.argv[3])
            calculation(num1, num2)


if (__name__ == "__main__"):
    main()
