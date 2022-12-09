import 'package:api_news/views/widgets/input_widget.dart';
import 'package:flutter/material.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Text('Authentication'),
            const SizedBox(
              height: 30,
            ),
             InputWidget(
              label: 'Username',
              controller: _usernameController,
              obscureText: false,
            ),
            const SizedBox(
              height: 30,
            ),
             InputWidget(
              label: 'Password',
              controller: _passwordController,
              obscureText: false,
            ),
             const SizedBox(
              height: 30,
            ),
            ElevatedButton(
              onPressed: (){},
               child: const Text('Login')
            ),
          ],
        ),
      ),
    );
  }
}
