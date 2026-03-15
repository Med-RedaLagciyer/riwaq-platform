import './PrimaryButton.css'

export default function PrimaryButton({ children, type = 'button', onClick, disabled, isLoading }) {
    return (
        <button
            className={`primary-button ${disabled || isLoading ? 'primary-button--disabled' : ''}`}
            type={type}
            onClick={onClick}
            disabled={disabled || isLoading}
        >
            {isLoading ? <span className="primary-button__spinner" /> : children}
        </button>
    )
}