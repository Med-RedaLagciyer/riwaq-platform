import { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { useMutation } from '@tanstack/react-query'
import { verifyEmail } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import CodeInput from '../../../components/ui/CodeInput/CodeInput'
import './VerifyEmailPage.css'

export default function VerifyEmailPage() {
    const navigate = useNavigate()
    const pendingEmail = useAuthStore((state) => state.pendingEmail)
    const addToast = useToastStore((state) => state.addToast)
    const [code, setCode] = useState('')
    const setTemporaryToken = useAuthStore((state) => state.setTemporaryToken)

    useEffect(() => {
        if (!pendingEmail) {
            navigate('/register')
        }
    }, [pendingEmail, navigate])

    const mutation = useMutation({
        mutationFn: verifyEmail,

        onSuccess: (response) => {
            setTemporaryToken(response.data.temporary_token)
            addToast('Email verified successfully', 'success')
            navigate('/complete-registration')
        },
        onError: (error) => {
            addToast(error.response?.data?.message || 'Something went wrong', 'error')
        },
    })

    const onSubmit = (e) => {
        e.preventDefault()
        if (code.length < 6) {
            addToast('Please enter the full 6-digit code', 'error')
            return
        }
        mutation.mutate({ email: pendingEmail, code })
    }

    return (
        <AuthLayout
            title="Check your email"
            subtitle={`We sent a 6-digit code to ${pendingEmail}`}
            showBack
            onBack={() => navigate('/register')}
        >
            <form className="auth-form" onSubmit={onSubmit}>
                <div className="form-group">
                    <div className="form-label">Verification code</div>
                    <CodeInput value={code} onChange={setCode} />
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 'Verifying...' : 'Verify email'}
                </button>
            </form>
        </AuthLayout>
    )
}