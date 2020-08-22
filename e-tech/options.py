#The following program automates html code for creating option tags

#Opening files
countries = open("countries.txt", 'r') #Opens countries file
options = open("options.txt", 'w')    #Opens output file

#For every country
for line in countries:
    options.write("<option value=\"")
    country = ""

    #For every character in country
    for char in line:
        #Eliminates newlines in output file
        if (char!='\n') and (char!='\0'):
            country = country + char
    options.write(country)
    options.write("\">")

    #For every character in country
    for char in line:
        if char=='_':            #replaces '_' with space
            options.write(' ')
            continue
        elif char=='\n':         #eliminates newline
            continue
        else:                    #accepted country name
            options.write(char)
    options.write("</option>\n")

#Closing opened files
countries.close()
options.close()


