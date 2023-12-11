
function voice(){
    let speech = new SpeechSynthesisUtterance();
    speech.text=document.getElementById("inputText").value;
    window.speechSynthesis.speak(speech);
}
function translateToMorse() {
    const inputText = document.getElementById("inputText").value.toUpperCase();
    const morseCode = {
        'A': '.-', 'B': '-...', 'C': '-.-.', 'D': '-..', 'E': '.',
        'F': '..-.', 'G': '--.', 'H': '....', 'I': '..', 'J': '.---',
        'K': '-.-', 'L': '.-..', 'M': '--', 'N': '-.', 'O': '---',
        'P': '.--.', 'Q': '--.-', 'R': '.-.', 'S': '...', 'T': '-',
        'U': '..-', 'V': '...-', 'W': '.--', 'X': '-..-', 'Y': '-.--',
        'Z': '--..', '0': '-----', '1': '.----', '2': '..---', '3': '...--',
        '4': '....-', '5': '.....', '6': '-....', '7': '--...', '8': '---..',
        '9': '----.', ' ': '/'
    };

    let morseText = '';
    for (let i = 0; i < inputText.length; i++) {
        const char = inputText[i];
        if (morseCode[char]) {
            morseText += morseCode[char] + ' ';
        } else {
            morseText += ' ';
        }
    }
    document.getElementById("morse").value = morseText;
}

function translateToText() {
    const inputMorse = document.getElementById("morse").value;
    const morseCode = {
        '.-': 'A', '-...': 'B', '-.-.': 'C', '-..': 'D', '.': 'E',
        '..-.': 'F', '--.': 'G', '....': 'H', '..': 'I', '.---': 'J',
        '-.-': 'K', '.-..': 'L', '--': 'M', '-.': 'N', '---': 'O',
        '.--.': 'P', '--.-': 'Q', '.-.': 'R', '...': 'S', '-': 'T',
        '..-': 'U', '...-': 'V', '.--': 'W', '-..-': 'X', '-.--': 'Y',
        '--..': 'Z', '-----': '0', '.----': '1', '..---': '2', '...--': '3',
        '....-': '4', '.....': '5', '-....': '6', '--...': '7', '---..': '8',
        '----.': '9', '/': ' '
    };

    const morseArray = inputMorse.split(' ');
    let text = '';
    for (let i = 0; i < morseArray.length; i++) {
        if (morseCode[morseArray[i]]) {
            text += morseCode[morseArray[i]];
        } else {
            text += ' ';
        }
    }
    document.getElementById("inputText").value= text;
}