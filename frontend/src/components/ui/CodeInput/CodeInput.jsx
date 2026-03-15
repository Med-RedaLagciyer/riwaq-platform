import { useRef } from 'react'
import './CodeInput.css'

export default function CodeInput({ value = '', onChange }) {
    const inputsRef = useRef([])
    const digits = value.split('').concat(Array(6).fill('')).slice(0, 6)

    const handleChange = (e, index) => {
        const val = e.target.value.replace(/\D/g, '').slice(-1)
        const newDigits = [...digits]
        newDigits[index] = val
        onChange(newDigits.join(''))
        if (val && index < 5) {
            inputsRef.current[index + 1].focus()
        }
    }

    const handleKeyDown = (e, index) => {
        if (e.key === 'Backspace' && !digits[index] && index > 0) {
            inputsRef.current[index - 1].focus()
        }
    }

    const handlePaste = (e) => {
        e.preventDefault()
        const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6)
        onChange(pasted.padEnd(6, '').slice(0, 6))
        const focusIndex = Math.min(pasted.length, 5)
        inputsRef.current[focusIndex].focus()
    }

    return (
        <div className="code-input">
            {digits.map((digit, index) => (
                <input
                    key={index}
                    ref={(el) => (inputsRef.current[index] = el)}
                    className="code-input__box"
                    type="text"
                    inputMode="numeric"
                    maxLength={1}
                    value={digit}
                    onChange={(e) => handleChange(e, index)}
                    onKeyDown={(e) => handleKeyDown(e, index)}
                    onPaste={handlePaste}
                />
            ))}
        </div>
    )
}