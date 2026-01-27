# Contributing to Quantum Astrology PLUS

## Numerology Module Contribution Guidelines

### Development Principles

1. **Type Safety**
   - Use `declare(strict_types=1)` in all files
   - Leverage PHP 8.4+ type hints
   - Prefer immutable data structures

2. **Calculation Integrity**
   - Follow established numerological calculation methods
   - Preserve master number handling (11, 22, 33)
   - Ensure consistent Pythagorean mapping

### Code Style

- Follow Laravel and PSR-12 coding standards
- Use Pint for automatic code formatting
- Run PHPStan at level 9 before submitting PRs

### Testing Requirements

- 100% test coverage for new calculations
- Unit tests for edge cases
- Feature tests for API endpoints
- Use Pest PHP testing framework

### Calculation Validation

Numerological calculations must:
- Reduce to single digit or master number
- Handle edge cases gracefully
- Provide meaningful interpretations
- Maintain mathematical consistency

### Contribution Process

1. Fork the repository
2. Create a feature branch
3. Implement changes
4. Write comprehensive tests
5. Run local test suite
6. Submit pull request with detailed description

### Pull Request Template

```markdown
## Numerology Module Enhancement

### Description
- What numerological feature/fix are you adding?

### Calculations Added/Modified
- List specific calculation methods
- Explain mathematical approach

### Test Coverage
- Unit tests added
- Edge cases handled
- Test coverage percentage

### Verification
- [ ] Passes all existing tests
- [ ] 100% test coverage
- [ ] Follows project calculation standards
```

### Recommended Tools

- PHPStan for static analysis
- Pest PHP for testing
- Rector for automated refactoring
- Pint for code styling

### Interpretation Guidelines

When adding number interpretations:
- Use concise, meaningful language
- Avoid overly generic statements
- Ground interpretations in numerological traditions
- Provide balanced, constructive insights

### Review Process

- Numerological accuracy check
- Code quality assessment
- Performance evaluation
- Security review

---

*Quantum Minds United - Bridging Ancient Wisdom and Modern Technology*