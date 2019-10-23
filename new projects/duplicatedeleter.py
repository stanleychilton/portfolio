import os

final_list = []

for root, dir, files in os.walk(os.path.expanduser("~\Desktop\etestcase")):
    file_list = []
    file_list.append(dir)
    for names in files:
        file_list.append(names)
        file_list.reverse()
    final_list.append(file_list)

    print(final_list)

    for i in final_list:
        cur_file = i.split('.')
        print(cur_file)
        count = 0
        file_dupe = 1
        while count < file_dupe:
            print("hi")
            for x in file_list:
                if cur_file[0] in x and "("+ str(file_dupe) +")" in x:
                    print(x, "exists")
                    file_dupe += 1
            count += 1
