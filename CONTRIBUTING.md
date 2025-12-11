# Contributing to Telecaller SaaS Platform

🎉 First off, thanks for taking the time to contribute! 🎉

## 🚀 How Can I Contribute?

### 🐛 Reporting Bugs
- Use the bug report template
- Include detailed steps to reproduce
- Add screenshots if applicable
- Specify your environment details

### 💡 Suggesting Features
- Use the feature request template
- Explain the problem you're trying to solve
- Describe your proposed solution
- Consider alternative approaches

### 🔧 Code Contributions

#### Development Setup
```bash
# Fork and clone the repo
git clone https://github.com/YOUR_USERNAME/telecaller-saas.git
cd telecaller-saas

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed
```

#### Coding Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Write tests for new features

#### Pull Request Process
1. Create a feature branch from `develop`
2. Make your changes
3. Add/update tests as needed
4. Ensure all tests pass
5. Update documentation if needed
6. Submit a pull request

## 📝 Style Guide

### PHP Code Style
```php
// Good
public function getUserLeads(User $user): Collection
{
    return $user->leads()
        ->where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->get();
}

// Bad
public function getUserLeads($user) {
    return $user->leads()->where('status','active')->orderBy('created_at','desc')->get();
}
```

### Database Conventions
- Use snake_case for table and column names
- Use descriptive foreign key names
- Add proper indexes for performance

### API Design
- Use RESTful conventions
- Return consistent JSON responses
- Include proper HTTP status codes
- Add pagination for list endpoints

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Writing Tests
- Write feature tests for API endpoints
- Write unit tests for complex business logic
- Use factories for test data
- Mock external services

## 📚 Documentation

- Update README.md for new features
- Add inline code comments
- Update API documentation
- Include examples in documentation

## 🤝 Community Guidelines

### Be Respectful
- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what's best for the community

### Be Helpful
- Help newcomers get started
- Share knowledge and best practices
- Provide constructive feedback
- Celebrate others' contributions

## 📞 Getting Help

- 💬 **Discussions**: Use GitHub Discussions for questions
- 🐛 **Issues**: Report bugs using issue templates
- 📧 **Email**: Contact maintainers at iamfaujdar@gmail.com

## 🏆 Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes for significant contributions
- Special mentions in project updates

---

**Happy Contributing! 🚀**

Built with ❤️ by [RoastCoder](https://github.com/RoastCoder)