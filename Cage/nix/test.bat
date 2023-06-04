set GOARCH=amd64
set GOOS=windows
go build -ldflags="-w -s -H windowsgui" -o cage64.exe .
set GOOS=linux
go build -ldflags="-w -s" -o cage64 .

set GOARCH=386
set GOOS=windows
go build -ldflags="-w -s -H windowsgui" -o cage86.exe .
set GOOS=linux
go build -ldflags="-w -s" -o cage86 .