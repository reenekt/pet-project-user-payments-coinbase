export type User = {
  id: number
  last_name: string
  first_name: string
  patronymic: string|null
  email: string
  phone_number: string
  birthdate: string
  password?: string | null
  payments?: any[] // TODO
}

export type UserSaveData = {
  last_name: string
  first_name: string
  patronymic?: string | null
  email: string
  phone_number: string
  birthdate: string
}

export type UserStoreData = UserSaveData & {
  password: string
  password_confirmation: string
}

export type UserUpdateData = UserSaveData & {
  password?: string | null
  password_confirmation?: string | null
}

export type UserStoreResult = {
  result: boolean
  user: User
}

export type UserUpdateResult = UserStoreResult

export type UserDeleteResult = {
  result: boolean
}
