import { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { useMutation } from '@tanstack/react-query'
import { verifyResetCode } from '../../../services/authService'
import useAuthStore from '../../../store/useAuthStore'
import useToastStore from '../../../store/useToastStore'
import AuthLayout from '../../../layouts/auth/AuthLayout'
import CodeInput from '../../../components/ui/CodeInput/CodeInput'
import './VerifyResetCodePage.css'

export default function VerifyResetCodePage() {
    const navigate = useNavigate()
    const pendingEmail = useAuthStore((state) => state.pendingEmail)
    const setTemporaryToken = useAuthStore((state) => state.setTemporaryToken)
    const addToast = useToastStore((state) => state.addToast)
    const [code, setCode] = useState('')

    useEffect(() => {
        if (!pendingEmail) {
            navigate('/forgot-password')
        }
    }, [pendingEmail, navigate])

    const mutation = useMutation({
        mutationFn: verifyResetCode,
        onSuccess: (response) => {
            setTemporaryToken(response.data.temporary_token)
            addToast('Code verified', 'success')
            navigate('/reset-password')
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
            title="Enter reset code"
            subtitle={`We sent a 6-digit code to ${pendingEmail}`}
            showBack
            onBack={() => navigate('/forgot-password')}
        >
            <form className="auth-form" onSubmit={onSubmit}>
                <div className="form-group">
                    <div className="form-label">Reset code</div>
                    <CodeInput value={code} onChange={setCode} />
                </div>
                <button type="submit" className="primary-button" disabled={mutation.isPending}>
                    {mutation.isPending ? 'Verifying...' : 'Verify code'}
                </button>
            </form>
        </AuthLayout>
    )
}