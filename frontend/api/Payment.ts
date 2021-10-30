import {User} from './User';

export type PaymentTarget = {
  wallet_address?: string
  wallet_currency?: string
  coinbase_charge_code?: string
  coinbase_charge_uuid?: string
  coinbase_checkout_uuid?: string
}
export type PaymentTargetMeta = any

export type Payment = {
  id: number
  comment: string | null
  user_from_id: string
  status: 'pending' | 'done' | 'fail' | 'cancelled'
  amount: string
  currency: string
  target_type: 'crypto_wallet' | 'coinbase' | 'credit_card' | 'paypal' | string
  target: PaymentTarget
  target_meta: PaymentTargetMeta
  created_at: string
  updated_at: string
  user_from?: User
}
