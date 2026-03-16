import './PasswordStrength.css'

const requirements = [
    { label: 'At least 8 characters', test: (p) => p.length >= 8 },
    { label: 'Uppercase letter', test: (p) => /[A-Z]/.test(p) },
    { label: 'Lowercase letter', test: (p) => /[a-z]/.test(p) },
    { label: 'Number', test: (p) => /[0-9]/.test(p) },
    { label: 'Special character', test: (p) => /[^A-Za-z0-9]/.test(p) },
]

export default function PasswordStrength({ password }) {
    if (!password) return null

    const passed = requirements.filter(r => r.test(password)).length
    const strength = passed / requirements.length

    const getColor = () => {
        if (strength <= 0.2) return 'var(--status-error)'
        if (strength <= 0.6) return 'var(--status-warning)'
        return 'var(--status-success)'
    }

    const getLabel = () => {
        if (strength <= 0.2) return 'Weak'
        if (strength <= 0.6) return 'Fair'
        if (strength < 1) return 'Good'
        return 'Strong'
    }

    return (
        <div className="password-strength">
            <div className="password-strength__bar">
                <div
                    className="password-strength__fill"
                    style={{
                        width: `${strength * 100}%`,
                        backgroundColor: getColor(),
                    }}
                />
            </div>
            <span className="password-strength__label" style={{ color: getColor() }}>
                {getLabel()}
            </span>
        </div>
    )
}