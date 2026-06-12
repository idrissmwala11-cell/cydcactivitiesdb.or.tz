@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 bg-gray-50/50 backdrop-blur-sm hover:bg-white hover:border-gray-300 placeholder-gray-400 text-gray-700 shadow-sm']) }}>
